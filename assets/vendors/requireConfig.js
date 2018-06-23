require.config({
    baseUrl:'/baixiu/baixiu/assets/vendors/',
    paths:{
        jquery: './jquery/jquery',
        bootstrap: './bootstrap/js/bootstrap',
        template: './template/template-web',
        pagination: './pagination/jquery.pagination',
        comments: './comments'
    },
    //给不支持模块插件绑定依赖项
    shim:{
        pagination:{
           deps:['jquery'] 
        },
        bootstrap:{
            deps:['jquery']
        }
    }

})