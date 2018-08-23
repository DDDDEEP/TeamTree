<script>
    var routes = {
    	nodes: {
    		update: '{{ RouteUri('nodes.update') }}',
    		update_status: '{{ RouteUri('nodes.update.update_status') }}',
            store: '{{ RouteUri('nodes.store') }}',
            destroy: '{{ RouteUri('nodes.destroy') }}'
    	},
    	projects: {
    		index: {
    			get_tree: '{{ RouteUri('projects.index.get_tree') }}'
    		}
    	}
    };
</script>