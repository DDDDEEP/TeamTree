var root = this;

root.DotInfo = {
	BG: {}
}

// ==============================================
//
//
//		PATH
//
//
// ==============================================

var Path2D = function() {
	this.points = [];
	this.radius = 150;
};

Path2D.prototype = {
	
	addLineTo: function(x, y) {
		return this.points.push(Vector2D.fromValues(x, y));
	},

	moveTo: function(x, y) {
		return this.points.push(Vector2D.fromValues(x, y));
	},

	addBezierCurveTo: function(sx, sy, hx, hy, ex, ey, q) {
		q = q ? q : 100;
		for (var i = 0; i < 1; i += (1 / q)) {
			this.quadBezierTo(sx, sy, hx, hy, ex, ey, i);
		};
	},
	
	// start, handle, end, percent
	quadBezierTo: function(sx, sy, hx, hy, ex, ey, p) {
		var x = Math.pow(1 - p, 2) * sx + 2 * (1 - p) * p * hx + Math.pow(p, 2) * ex;
	    var y = Math.pow(1 - p, 2) * sy + 2 * (1 - p) * p * hy + Math.pow(p, 2) * ey;
	    return this.points.push(Vector2D.fromValues(x, y));
	},

	// start, handle1, handle2, end, percent
	cubicBezierTo: function(sx, sy, h1x, h1y, h2x, h2y, ex, ey, p) {
		var x = this.cubicN(p, sx, h1x, h2x, ex);
	    var y = this.cubicN(p, sy, h1y, h2y, ey);
	    return this.points.push(Vector2D.fromValues(x, y));
	},
	
	// calculates cubicN
	cubicN: function(pct, a, b, c, d) {
		var t2 = pct * pct, t3 = t2 * pct;
	    return a + (-a * 3 + pct * (3 * a - a * pct)) * pct + (3 * b + pct * (-6 * b + b * 3 * pct)) * pct + (c * 3 - c * 3 * pct) * t2 + d * t3;
	}
};

// ==============================================
//
//
//		DOT
//
//
// ==============================================

var Dot = function(parent, position, velocity, scale, maxSpeed, showText, trail) {

	var randN =  parseInt(randomNumber(1,2));
	this.randS =  parseInt(randomNumber(1,4));

	this._parent = parent;
	this.ctx = this._parent.ctx;
	this.startScale = 0;
	this.scale = scale;
	this.radius = this.scale;
	this.opacity = parseInt(randomNumber(2,10)) / 10;
	this.maxSpeed = maxSpeed;
	this.rotation = randomNumber(0.5,1)/100;
	this.position = position;
	this.acceleration = Vector2D.create();
	this.velocity = velocity;
	this.maxForce = 0.2;
	this.wanderTheta = 0.005;
	this.life = 10;
	this.lifeSpent = 0;
	this.showText = showText;
	this.trail = trail;
	this.setup();	
};

Dot.prototype = {

	run: function() {
		this.update();
		this.draw();
	},

	setup: function() {
		var shape, color;

		this.g = new PIXI.Graphics();
	
		if (this.randS === 1) {
			shape = "circle";			
		} else if (this.randS === 2) {
			shape = "square";			
		} else if (this.randS === 3) {
			shape = "cross";			
		} else if (this.randS === 4) {
			shape = "circle";			
		} 

		color = this.trail === "trail" ? "red" : "grey";
		this.g = PIXI.Sprite.fromImage("../img/" + shape + "-" + color + ".png");
		this._parent.stage.addChild(this.g);
	},

	draw: function() {
		this.g.position.x = this.position[0];
		this.g.position.y = this.position[1];
		this.g.alpha = this.opacity;
		this.g.scale.x = this.startScale;
		this.g.scale.y = this.startScale;
		this.g.rotation += this.rotation;
	},

	update: function() {

		this.life -= 1 / 500;
		this.lifeSpent++;
		this.startScale += 0.05;

		if (this.position[0] < 120) this.scale -= 0.025;
		if (this.startScale > this.scale) this.startScale = this.scale;
		if (this.scale < 0.5) this.startScale = 0;

		this.applyMovement();
	},

	dead: function() {
		var bool = this.position[0] < 44 ? true : false;
		if (bool) this._parent.stage.removeChild(this.g);
		return bool;
	},

	applyMovement: function() {
		Vector2D.add(this.velocity, this.velocity, this.acceleration);
		Vector2D.limit(this.velocity, this.velocity, this.maxSpeed);
		Vector2D.add(this.position, this.position, this.velocity);
		Vector2D.mult(this.acceleration, this.acceleration, [0,0]);
	},

	seek: function(t, p) {
		var target = Vector2D.sub(t, t, p);
	    return this.steer(target);
	},

	wander: function(r, d, c) {
		var circlePos, wanderTarget;
		// Wander radius
		var wanderR = r;
		// Wander distance
		var wanderD = d;
		// Wander change
		var wanderC = c;
		// Calculate the new location to steer towards the wander circle
		circlePos = Vector2D.clone(this.velocity);
		Vector2D.normalize(circlePos, circlePos);
		Vector2D.mult(circlePos, circlePos, [wanderD, wanderD]);
		Vector2D.add(circlePos, circlePos, this.position);
		// Wander random theta
		this.wanderTheta += Math.random() * (Math.floor(Math.random()*2) == wanderC ? wanderC : -wanderC) - (Math.floor(Math.random()*2) == wanderC ? wanderC : -wanderC) * .5;
		// Offset the wander theta
		wanderTarget = [Math.cos(this.wanderTheta) * wanderR, Math.sin(this.wanderTheta) * wanderR];
		Vector2D.add(wanderTarget, wanderTarget, circlePos);		
		// seek the target destination
		return this.seek(wanderTarget, this.position);
	},

	followPath: function(path, radius) {
		var predict, predictPos, target, worldRecord, a, b, normalPoint, dir, d; 
		predict = Vector2D.clone(this.velocity);
		predictPos = Vector2D.create();
		// predict our future location
		Vector2D.normalize(predict, predict);
		Vector2D.scale(predict, predict, radius);
		// predict our future location		
		Vector2D.add(predictPos, predictPos, this.position);
		Vector2D.add(predictPos, predictPos, predict);
		// define out target and worldrecord
		// will be updated with shortest distance to path. Start with a very high value.
	    target = null;
	    worldRecord = 1000000;
		// loop through our path data to collect points
		for (var i = 0; i < path.points.length; i++) {
			// get the current and next point in path
		    a = Vector2D.clone(path.points[i]);
		    b = Vector2D.clone(path.points[(i + 1) % path.points.length]);
			// calculate the normal point
			normalPoint = this.getNormalPoint(predictPos, a, b);
			// calculate the direction
			dir = Vector2D.clone(b);
			Vector2D.sub(dir, dir, a);
			// Set a normal point to the end of the current path segment and
			// re-calculate direction, if the vehicle is not within it
			if (normalPoint[0] < Math.min(a[0], b[0]) || normalPoint[0] > Math.max(a[0], b[0]) || normalPoint[1] < Math.min(a[1], b[1]) || normalPoint[1] > Math.max(a[1], b[1])) {
		        normalPoint = Vector2D.clone(b);
		        a = Vector2D.clone(path.points[(i + 1) % path.points.length]);
		        b = Vector2D.clone(path.points[(i + 2) % path.points.length]);
		        dir = Vector2D.clone(b);
		        Vector2D.sub(dir, dir, a);
			}
		    // set a normal point to the end of the current path segment and
			d = Vector2D.dist(predictPos, normalPoint);
			// calculate steering target for current path segment if the vehicle is going in segment direction
			if (d < worldRecord) {
				worldRecord = d;
				target = normalPoint;
				Vector2D.normalize(dir, dir);
				Vector2D.scale(dir, dir, radius);
				Vector2D.add(target, target, dir);
			}
		}		
	    // steer if the vehicle is out of the 1/5 of the path's radius ..
	    // .. do not steer otherwise
	    // using a part of path's radius creates kind of non-straightforward movement ..
	    // .. instead of "within radius" movement when object bounces from path edges
	    if (worldRecord > path.radius / 5) {
	      return this.seek(target, this.position);
	    } else {
	      return Vector2D.create();
	    }
	},

	seperate: function(agents, distance) {
		var agent, d, diff;
		var desiredSeparation = this.radius * 2 + distance;
	    var steer = Vector2D.create();
	    var count = 0;
	    // loop through each vehicle
	    for (var i = 0; i < agents.length; i++) {
			agent = agents[i];
			// get distance between current and other vehicle
			d = Vector2D.dist(this.position, agent.position);
			// seperate if the other agent is within specified distance
			if ((d > 0) && (d < desiredSeparation)) {
				diff = Vector2D.sub(Vector2D.create(), this.position, agent.position); // Point away from the vehicle
				Vector2D.normalize(diff, diff);
				// The closer the other vehicle is, the more current one will flee and vice versa
				Vector2D.scale(diff, diff, 1 / d);
				Vector2D.add(steer, steer, diff);
				count++;
			}
		}
		// get average steering vector
		if (count > 0) Vector2D.scale(steer, steer, 1 / count);
	    return this.steer(steer);
	},

	steer: function (target) {
	    var steer;
		var length = Vector2D.length(target, target);
		// normalize and scale vector
	    Vector2D.normalize(target, target);
	    Vector2D.mult(target, target, [this.maxSpeed,this.maxSpeed]);
		// calculate the steer force
	    steer = target;
	    Vector2D.sub(steer, steer, this.velocity);
	    Vector2D.limit(steer, steer, this.maxForce);
	    Vector2D.add(this.acceleration, this.acceleration, steer);
	    return steer;
	},

	/**
		* HELPER(S)
		* ================
	*/

	getNormalPoint: function (p, a, b) {
		var ap = Vector2D.clone(p);
		var ab = Vector2D.clone(b);
		// Perform scalar projection calculations
		Vector2D.sub(ap, ap, a);
		Vector2D.sub(ab, ab, a);
		Vector2D.normalize(ab, ab);
		Vector2D.scale(ab, ab, Vector2D.dot(ap, ab));
		var normalPoint = Vector2D.add(Vector2D.create(), Vector2D.clone(a), ab);
		return normalPoint;
	}

};

// ==============================================
//
//
//		BG
//
//
// ==============================================

DotInfo.BG = QS.extend({

	container: "dot-info-bg",
	context: "2d",
	background: "0a0a1e",

	setup: function(args) {
		// create a renderer instance
		this.stage = new PIXI.Stage("0x" + this.background);
		// set the context and container
		this.ctx = PIXI.autoDetectRenderer(this.size[0], this.size[1], null, true);
		document.body.appendChild(this.ctx.view);
	    // finally query the various pixel ratios
	    var devicePixelRatio = window.devicePixelRatio || 1;
	    var backingStoreRatio = this.ctx.view.webkitBackingStorePixelRatio || this.ctx.view.mozBackingStorePixelRatio || this.ctx.view.msBackingStorePixelRatio || this.ctx.oBackingStorePixelRatio || this.ctx.backingStorePixelRatio || 1;
		var ratio = devicePixelRatio / backingStoreRatio;
		// setup size and detect if we're retina
		this.ctx.view.width = this.size ? this.size[0] * ratio : 800 * ratio;
	  	this.ctx.view.height = this.size ? this.size[1] * ratio : 800 * ratio;

		this.attrs = args || {};
		this.dots = [];
		this.size = [window.innerWidth, window.innerHeight];
		this.ctx.resize(window.innerWidth, window.innerHeight);
	    this.createTrail();
	    this.frameRate = 0;
	},

	update: function(data) {
		this.attrs.data = data;
	},

	draw: function() {

		this.frameRate += 1;

		if (this.frameRate%3 == 0) this.createDotOne();
		if (this.frameRate%4 == 0) this.createDotTwo();

		for (var i = 0; i < this.dots.length; i++) {
			this.dots[i].run();
			this.dots[i].wander(randomNumber(3, 5), randomNumber(150, 300), randomNumber(-0.005, 0.005));
			if (this.dots[i].trail === "trail") {
				this.dots[i].followPath(this.trail, 110);
			} else if (this.dots[i].trail === "trailTwo") {
				this.dots[i].followPath(this.trailTwo, 130);
			}
			this.dots[i].seperate(this.dots, randomNumber(20, 50));
			if (this.dots[i].dead()) this.dots.splice(i, 1);
		};
	},

	createTrail: function() {
		var path = new Path2D();
		path.moveTo(this.size[0]-50, this.size[1] - this.size[1]/8);
		path.addLineTo(this.size[0] - this.size[0]/3, this.size[1] - this.size[1]/1.6);
		path.addLineTo(this.size[0]/2, this.size[1] - this.size[1]/1.3);
		path.addLineTo(this.size[0]/3, (this.size[1]/2)-200);
		path.addLineTo(this.size[0]/4 - 150, (this.size[1]/3) + 50);
		path.addLineTo(-30, (this.size[1]/3) + 120);
		path.addLineTo(-30, this.size[1]);
		this.trail = path;

		var pathTwo = new Path2D();
		// pathTwo.moveTo(this.size[0]-50, this.size[1] - this.size[1]/2);
		pathTwo.moveTo(this.size[0] - this.size[0]/3, this.size[1] - this.size[1]/1.9);
		pathTwo.addLineTo(this.size[0]/2, this.size[1] - this.size[1]/2.1);
		pathTwo.addLineTo(this.size[0]/3, this.size[1] - this.size[1]/2.3);
		pathTwo.addLineTo(this.size[0]/4 - 150, (this.size[1]/3) + 50);
		pathTwo.addLineTo(-30, this.size[1]/3);
		pathTwo.addLineTo(-30, -30);
		this.trailTwo = pathTwo;
	},

	createDotOne: function() {
	    var position = [
	    	randomNumber((this.size[0] - 50), (this.size[0] - 150)),
	    	randomNumber((this.size[1] - 50), (this.size[1] - 150))
	    ];
	    var velocity = Vector2D.create(randomNumber(5, -2), randomNumber(5, -2));
	    var scale = randomNumber(0.1, 0.5);
	    var maxSpeed = randomNumber(1,4);
        this.dots.push(new Dot(this, position, velocity, scale, maxSpeed, false, "trail"));
	},

	createDotTwo: function() {
	    var position = [
	    	randomNumber((this.size[0] - 50), (this.size[0] - 150)),
	    	randomNumber((this.size[1] - 250), ((this.size[1] - 400)))
	    ];
	    var velocity = Vector2D.create(randomNumber(-5, -2), randomNumber(-5, -2));
		var scale = randomNumber(0.1, 0.5);
	    var maxSpeed = randomNumber(1,4);
        this.dots.push(new Dot(this, position, velocity, scale, maxSpeed, false, "trailTwo"));
	},

	resize: function(e) {
		this.size = [window.innerWidth, window.innerHeight];
		this.ctx.resize(this.size[0], this.size[1]);
		this.createTrail();
	}
	
});


function randomNumber(min, max) {
	if (max == null) { 
		max = min; 
		min = 0;
	}
	return min + Math.floor(Math.random() * (max - min + 1));
}

// WHEN LOADED START
onload = function() {	
	root.dotInfoBG = new root.DotInfo.BG();
};
