/*
|--------------------------------------------------------------------------
| 全局辅助函数
|--------------------------------------------------------------------------
*/

/**
 * ------------------------------------------------------------------------
 * JavaScript实现Laravel的route函数
 * ------------------------------------------------------------------------
 * 函数返回示例：
 * route('/blog/{blog}', {blog: 1}); //返回 /blog/1
 * route('/blog/{blog}', {blog: 1, preview: 1}); //返回 /blog/1?preview=1
 *
 * 使用示例：
 * 在blade模板中把这个页面所有需要用到的路定义在一个对象中：
 * var routes = {
 *     blog: {
 *         show: '{{ route_uri('blog.show') }}',
 *         update: '{{ route_uri('blog.update') }}',
 *         destroy: '{{ route_uri('blog.destroy') }}'
 *     }
 * };
 * 在js文件里就可以使用：
 * $.post(route(routes.blog.update, {blog: 1}), {title: 'xxx', content: 'xxx'})
 */
route = (routeUrl, param) => {
  let append = [];

  for (let x in param) {
    let search = '{' + x + '}';

    if (routeUrl.indexOf(search) >= 0) {
      routeUrl = routeUrl.replace('{' + x + '}', param[x]);
    } else {
      append.push(x + '=' + param[x]);
    }
  }

  let url = '/' + _.trimStart(routeUrl, '/');

  if (append.length == 0) {
    return url;
  }

  if (url.indexOf('?') >= 0) {
    url += '&';
  } else {
    url += '?';
  }

  url += append.join('&');

  return url;
}

/**
 * 获取url中的GET参数
 *
 * @param  string  name  GET参数名
 */
GetParam = function(name)
{
  var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
  var r = window.location.search.substr(1).match(reg);
  if (r != null) return unescape(r[2]); return null;
}