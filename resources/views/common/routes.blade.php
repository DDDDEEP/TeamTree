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
    			get_tree: '{{ RouteUri('show_tree') }}'
    		},
            store: '{{ RouteUri('projects.store') }}'
    	}
    };
</script>