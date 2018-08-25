## 接口规范：
 -  资源控制器操作路由：  

    | 动作 | URI | 行为 | 路由名称 |
    | --- | --- | --- | --- |
    | GET | /resources | index | resources.index |
    | POST | /resources | store | resources.store |
    | PUT|PATCH | /resources/{resource} | update | resources.update |
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
 -  通过链接： teamtree.test/资源名 即可获取对应的资源。

 -  可发送对应资源的同名字段值过滤对应的资源，如发送参数对 *id = 1* 即可获得 *id = 1* 的资源，  

 -  支持对单关联值得过滤，但要通过 *relate* 加载对应资源，  
    如对user资源，发送参数对 *project-id = 1*，即可获得 *project.id = 1* 的 *user*。  

 -  值可以用 ',' 分割多个值，键名可带以'@'开头的后缀，如 *id@neq = 1*，现支持的后缀如下：  

    | 后缀 | 意义 | 备注 |
    | --- | --- | --- |
    | 无|@eq | 过滤等值资源 | 用或逻辑处理多个值，如 *id = 1,2,3* 时，过滤得到 *id* 在 [1,2,3] 的资源 |
    | @neq | 过滤不等值资源 | 用与逻辑处理多个值，如 *id@neq = 1,2,3* 时，过滤得到 *id* 不在 [1,2,3] 的资源 |
    | @like | 模糊搜素 | 与@eq相同，不同的是可类似sql的like '%value%'进行模糊匹配 |


 -  特殊键值，字段值均可以用','分割：  

    | 键名 | 意义 | 备注 |
    | --- | --- | --- |
    | relate | 接收关联方法名，加载关联值 |  |
    | unique | 接收字段值，根据字段值去重 |  |
    | sortBy | 接收字段值与顺序值排序，以'.'分割 | 顺序值有'asc'与'desc'，若省略顺序值则默认为'asc'，示例：id.desc,name.asc |

## *GET* 接口文档:
 -  获取对应项目的树结构。
    >**请求URL：**_/projects/1/get_tree_
    >**请求参数：**
    >| 参数名 | 类型 | 含义 | 备注 |
    >| --- | --- | --- | --- |
    >| id | int | 老人id |  |
    >| from | string | 开始时间 | 格式为YYYY-MM-DD |
    >| to | string | 截止时间  | 格式为YYYY-MM-DD |
    >| type_id | int | 消费类型 | 【可选】，不选为全部类型<br/>*1* 物资消耗；<br>*2* 药物消耗；<br>*3* 零散可选月交费；<br>*4* 临时加插的费用；<br>*5* 临时加插的退费；<br> |
    >| page | int | 页码 | 【可选】，不选则为查询全部 |
    >| limit | int | 每页数量 | 【可选】，不选则为查询全部 |