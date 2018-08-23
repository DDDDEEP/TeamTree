	var margin = {
        top: 20,
        right: 120,
        bottom: 20,
        left: 120
    },
    width = $(".layui-body").width();
    height = $(".layui-body").height();

    var root = @json($tree);

    var i = 0,
        duration = 750,
        rectW = 100,
        rectH = 30;

    var tree = d3.layout.tree().nodeSize([200, 50]);
    var diagonal = d3.svg.diagonal()
        .projection(function (d) {
        return [d.x + rectW / 2, d.y + rectH / 2];
    });

    var svg = d3.select("#body").append("svg").attr("width", width).attr("height", height)
        .call(zm = d3.behavior.zoom().scaleExtent([1,3]).on("zoom", redraw)).append("g");

    //necessary so that zoom knows where to zoom and unzoom from
    zm.translate([width / 2, height / 4]);

    root.x0 = 0;
    root.y0 = height / 2;

    function collapse(d) {
        if (d.children) {
            d._children = d.children;
            d._children.forEach(collapse);
            d.children = null;
        }
    }

    update(root);
    centerNode(root);

    d3.select("#body").style("height", "800px");

    function centerNode(source) {
        scale = zm.scale();
        x = -source.y0;
        y = -source.x0;
        x = x * scale + height / 4;
        y = y * scale + width / 2;
        d3.select('g').transition()
            .duration(duration)
            .attr("transform", "translate(" + y + "," + x + ")scale(" + scale + ")");
        zm.scale(scale);
        zm.translate([y, x]);
    }

    function update(source) {
        // Compute the new tree layout.
        var nodes = tree.nodes(root).reverse(),
            links = tree.links(nodes);

        // Normalize for fixed-depth.
        nodes.forEach(function (d) {
            d.y = d.depth * 180;
        });

        // Update the nodes…
        var node = svg.selectAll("g.node")
            .data(nodes, function (d) {
            return d.no || (d.no = ++i);
        });

        // Enter any new nodes at the parent's previous position.
        var nodeEnter = node.enter().append("g")
            .attr("class", "node")
            .attr("transform", function (d) {
            return "translate(" + (source.x0) + "," + (source.y0) + ")";
        });


        nodeEnter.append("rect")
            .attr("width", rectW)
            .attr("height", rectH)
            .attr("stroke", "black")
            .attr("stroke-width", 1)
            .style("fill", function (d) {
            return d._children ? "lightsteelblue" : "#fff";
        })
            .on("click", showMenu);

        nodeEnter.append("text")
            .attr("x", rectW / 2)
            .attr("y", rectH / 2)
            .attr("dy", ".35em")
            .attr("text-anchor", "middle")
            .text(function (d) {
            return d.name;
        })
            .on("click", showMenu);

        nodeEnter.append("circle")
            .attr("cx", rectW)
            .attr("y", 0)
            .attr("dy", ".35em")
            .attr("r", "8")
            .attr("stroke", "black")
            .attr("stroke-width", 1);

        nodeEnter.append("text")
            .attr("x", 0)
            .attr("y", -8)
            .attr("dy", ".35em")
            .attr("text-anchor", "middle")
            .text('🧙‍超级管理员')
            .style('font-size', '13px');

        nodeEnter.append("text")
            .attr("x", rectW)
            .attr("y", 0)
            .attr("dy", ".35em")
            .attr("text-anchor", "middle")
            .text('-')
            .style('font-size', '22px')
            .on("click", click);

        // Transition nodes to their new position.
        var nodeUpdate = node.transition()
            .duration(duration)
            .attr("transform", function (d) {
            return "translate(" + d.x + "," + d.y + ")";
        });

        nodeUpdate.select("rect")
            .attr("width", rectW)
            .attr("height", rectH)
            .attr("stroke", "black")
            .attr("stroke-width", 1)
            .style("fill", function (d) {
                if (d.status == 2) {
                    return 'yellow'
                } else if (d.status == 3) {
                    return '#0ad20a'
                } else {
                    return '#fff'
                }
        });

        nodeUpdate.select("text")
            .style("fill-opacity", 1);

        // Transition exiting nodes to the parent's new position.
        var nodeExit = node.exit().transition()
            .duration(duration)
            .attr("transform", function (d) {
            return "translate(" + source.x + "," + source.y + ")";
        })
            .remove();

        nodeExit.select("rect")
            .attr("width", rectW)
            .attr("height", rectH)
        //.attr("width", bbox.getBBox().width)""
        //.attr("height", bbox.getBBox().height)
        .attr("stroke", "black")
            .attr("stroke-width", 1);

        nodeExit.select("text");

        // Update the links…
        var link = svg.selectAll("path.link")
            .data(links, function (d) {
            return d.target.no;
        });

        // Enter any new links at the parent's previous position.
        link.enter().insert("path", "g")
            .attr("class", "link")
            .attr("x", rectW / 2)
            .attr("y", rectH / 2)
            .attr("d", function (d) {
            var o = {
                x: source.x0,
                y: source.y0
            };
            return diagonal({
                source: o,
                target: o
            });
        });

        // Transition links to their new position.
        link.transition()
            .duration(duration)
            .attr("d", diagonal);

        // Transition exiting nodes to the parent's new position.
        link.exit().transition()
            .duration(duration)
            .attr("d", function (d) {
            var o = {
                x: source.x,
                y: source.y
            };
            return diagonal({
                source: o,
                target: o
            });
        })
            .remove();

        // Stash the old positions for transition.
        nodes.forEach(function (d) {
            d.x0 = d.x;
            d.y0 = d.y;
        });
    }

    // Toggle children on click.
    function click(d) {
        if (d.children) {
            $(this).text("+")
            d._children = d.children;
            d.children = null;
        } else {
            $(this).text("-")
            d.children = d._children;
            d._children = null;
        }
        update(d);
        centerNode(d);
    }

    //Redraw for zoom
    function redraw() {
      //console.log("here", d3.event.translate, d3.event.scale);
      svg.attr("transform",
          "translate(" + d3.event.translate + ")"
          + " scale(" + d3.event.scale + ")");
    }
