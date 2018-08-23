<script>
    var routes = {
    	nodes: {
    		update: '{{ RouteUri('nodes.update') }}'
    	},
    	projects: {
    		index: {
    			get_tree: '{{ RouteUri('projects.index.get_tree') }}'
    		}
    	}
    };
</script>