## 接口规范：
 -  资源控制器操作路由：  

    | 动作 | URI | 行为 | 路由名称 |
    | --- | --- | --- | --- |
    | GET | /resources | index | resources.index |
    | POST | /resources | store | resources.store |
    | PUT\|PATCH | /resources/{resource} | update | resources.update |
    | DELETE | /resources/{resource} | destroy | resources.destroy |


 -  返回数据格式如下：
```
    {
        "data": {
            "id": 10,
            "project_id": 1,
            "user_id": 4,
            "role_id": "5",
            "status": 1,
            "created_at": "2018-08-24 11:37:26",
            "updated_at": "2018-08-24 11:38:24"
        },
        "errcode": 0, // 0成功，1失败
        "errmsg": "",
        "hintmsg": ""
    }
```

## *Resource* 接口文档:
 - 通过链接： teamtree.test/资源名 即可获取对应的资源。

 - 可发送对应资源的同名字段值过滤对应的资源，如发送参数对 *id = 1* 即可获得 *id = 1* 的资源，  

 - 支持对单关联值得过滤，但要通过 *relate* 加载对应资源，  
    如对user资源，发送参数对 *project-id = 1*，即可获得 *project.id = 1* 的 *user*。  

 - 值可以用 ',' 分割多个值，键名可带以'@'开头的后缀，如 *id@neq = 1*，现支持的后缀如下：  

    | 后缀 | 意义 | 备注 |
    | --- | --- | --- |
    | 无|@eq | 过滤等值资源 | 用或逻辑处理多个值，如 *id = 1,2,3* 时，过滤得到 *id* 在 [1,2,3] 的资源 |
    | @neq | 过滤不等值资源 | 用与逻辑处理多个值，如 *id@neq = 1,2,3* 时，过滤得到 *id* 不在 [1,2,3] 的资源 |
    | @like | 模糊搜素 | 与@eq相同，不同的是可类似sql的like '%value%'进行模糊匹配 |


 - 特殊键值，字段值均可以用','分割：  

    | 键名 | 意义 | 备注 |
    | --- | --- | --- |
    | relate | 接收关联方法名，加载关联值 |  |
    | unique | 接收字段值，根据字段值去重 |  |
    | sortBy | 接收字段值与顺序值排序，以'.'分割 | 顺序值有'asc'与'desc'，若省略顺序值则默认为'asc'，示例：id.desc,name.asc |

## *GET* 接口文档:
>### project_user资源特殊参数
>**请求URL：** */project_user*
>**特殊请求参数：**
>
>| 参数名 | 类型 | 含义 | 备注 |
>| --- | --- | --- | --- |
>| *node_id【可选】 | int | 节点id，可获取该节点下的用户对于的节点角色 |  |

* * *

>### **获取某用户对于一项目的树的结构。**
>**请求URL：** */projects/1/get_tree*
>**请求参数：**
>
>| 参数名 | 类型 | 含义 | 备注 |
>| --- | --- | --- | --- |
>| user_id | int | 用户id |  |
>**返回数据格式如下：**
>
>```json
>{
>   "data": {
>       "id": 1,
>       "project_id": 1,
>       "parent_id": null,
>       "name": "根节点",
>       "height": 1,
>       "status": 1,
>       "description": "Fugit maxime veniam quaerat aut quae.",
>       "created_at": "1988-03-15 15:53:01",
>       "updated_at": "2018-08-24 11:37:26",
>       "role": {
>           "id": 6,
>           "project_id": null,
>           "display_name": "项目创始人",
>           "description": "Non molestias voluptatibus fuga.",
>           "level": 6,
>           "created_at": "2009-12-18 02:57:09",
>           "updated_at": "2018-08-24 11:37:26",
>           "node": null
>       },
>       "children": [
>           {
>               "id": 2,
>               "project_id": 1,
>               "parent_id": 1,
>               "name": "有节点角色的子节点",
>               "height": 2,
>               "status": 1,
>               "description": "A vitae autem qui perspiciatis recusandae.",
>               "created_at": "2000-08-29 04:25:37",
>               "updated_at": "2018-08-24 11:37:26",
>               "role": {
>                   "id": 6,
>                   "project_id": null,
>                   "display_name": "项目创始人",
>                   "description": "Non molestias voluptatibus fuga.",
>                   "level": 6,
>                   "created_at": "2009-12-18 02:57:09",
>                   "updated_at": "2018-08-24 11:37:26",
>                   "node": null
>               },
>               "children": [],
>               "users": []
>           }
>       ],
>       "users": []
>   },
>   "errcode": 0,
>   "errmsg": "",
>   "hintmsg": ""
>}
>```
