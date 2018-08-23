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
    		},
            store: '{{ RouteUri('projects.store') }}',
            update: '{{ RouteUri('projects.update') }}'
        },
        show_tree: '{{ RouteUri('show_tree') }}',
        permission_role: {
            index: '{{ RouteUri('permission_role.index') }}'
        },
        project_user: {
            destroy: '{{ RouteUri('project_user.destroy') }}',
            update: '{{ RouteUri('project_user.update') }}',
            store: '{{ RouteUri('project_user.store') }}'
        },
        users: {
            index: '{{ RouteUri('users.index') }}'
        }
    };
</script>