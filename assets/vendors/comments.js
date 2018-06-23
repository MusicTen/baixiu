define(['template','bootstrap','pagination'],function(template,bootstrap,pagination){
        // 待审核（held）/ 准许（approved）/ 拒绝（rejected）/ 回收站（trashed）          
        var state ={
          held: '待审核',
          approved: '批准',
          rejected: '拒绝',
          trashed: '回收站'
        }
        var current = 1;
        //1-获取评论数据并渲染
        function render(page,pageSize){
          $.ajax({
            url:'./comments/comGet.php',
            type:'get',
            data:{
              page: page || 1,
              pageSize:pageSize || 10
            },
            dataType:'json',
            success:function(info){
              console.log(info);
              var obj = {
                list:info,
                state:state
              }
              $('tbody').html(template('tmp',obj));

              //让全选按钮重置,批量操作隐藏
              $('.tb-chk').prop('checked',false);
              $('.btn-batch').hide();
            }
          })            
        }
        render();
        //2-生成分页
        function setPage(page){
          $.ajax({
            url:'./comments/comTotal.php',
            dataType: 'json',
            success:function(info){
              $('.page-box').pagination(info.total,{
                prev_text:'上一页',
                next_text:'下一页',
                num_display_entries: 5, //连续主体个数
                current_page:page || 0, //默认选中那一页
                //num_edge_entries: 1, 
                load_first_page:false, //初始化完成不执行回调函数
                callback:function(index){
                  render(index+1);
                  current = index + 1;
                }
              })     
            }
          })
        }
        setPage();
        //3-批准评论
        //点击批准按钮，获取对应数据的id，传递给后台进行批准
        //ajax返回数据动态生成的结构，给动态生成元素绑定事件用事件委托
        //$(父盒子).on(事件类型，子元素，function(){})
        $('tbody').on('click','.btn-approved',function(){
          var id = $(this).parent().attr('data-id');
          $.ajax({
            url:'./comments/comApproved.php',
            data:{id:id},
            success:function(info){
              render(current);
            }
          })
        })
        
        //4-删除评论
        $('tbody').on('click','.btn-del',function(){
          var id = $(this).parent().attr('data-id');
          $.ajax({
            url:'./comments/comDel.php',
            data:{id:id},
            dataType: 'json',
            success: function(info){
              var maxPage = Math.ceil(info.total/10)
              if(current>maxPage) {
                current = maxPage;
              }
              render(current);
              setPage(current-1);
            }
          })
        })
        
        //5-全选功能
        $('.th-chk').change(function(){
          var flag = $(this).prop('checked');
          $('.tb-chk').prop('checked',flag);
          if(flag){
            
            $('.btn-batch').show();
          } else {
            $('.btn-batch').hide();
          }
        })
        //5-多选功能
        // 1 如果所有小复选框全部选中，则全选按钮选中，否则取消
        // 2 如果有小复选框被选中，批量按钮显示，否则隐藏
        // 3 在渲染方法中，每次页面重新渲染，将全选 和批量操作按钮 进行重置
        $('tbody').on('change','.tb-chk',function(){
          //console.log($('.tb-chk').length); //所有复选框
          //console.log($('.tb-chk:checked').length); //被选中的复选框
          if($('.tb-chk').length == $('.tb-chk:checked').length){
            $('.th-chk').prop('checked',true)
          } else {
            $('.th-chk').prop('checked',false)
          }
          if($('.tb-chk').length>0){
            $('.btn-batch').show();
          } else {
            $('.btn-batch').hide();
          }
        })
        //5-1获取多选id
        function getId(){
          var arr = [];
          $('.tb-chk:checked').each(function(index,ele){            
            var id = $(ele).parent().attr('data-id');
              arr.push(id);
          })
          arr = arr.join();
          return arr;
          //$(this).parent().attr('data-id');
        }
        //5-2批量批准
        $('.btn-approveds').click(function(){
          var id = getId();
          //alert(getId());
          $.ajax({
            url:'./comments/comApproved.php',
            data: {id:id},
            success:function(){
              render(current);
            }
          })
        })
        //5-3批量删除
        $('.btn-dels').click(function(){
          //alert('1')
          var id = getId();
          $.ajax({
            url:'./comments/comDel.php',
            data :{id:id},
            dataType:'json',
            success:function(info){
              var maxPage = Math.ceil(info.total/10)
              if(current>maxPage){
                current = maxPage
              }
              render(current);
              setPage(current+1);
            }
          })
        })
});