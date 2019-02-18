

var postId= 0;
var postBody;
$('.edit_post').click(function(event){
    event.preventDefault();
    postBody = event.target.parentNode.parentNode.childNodes[1];
    var post = postBody.textContent;
    postId   = event.target.parentNode.parentNode.dataset['post_id'];
    // console.log($(this).closest('.post').find('p').text());
    $('#edit-post').val(post);
    $('#edit_modal').modal();
});

$('#save_edit_post').click(function(){
    var url = $('#url_edit').val();
    dataObj = {
        body   : $('#edit-post').val(),
        postId : postId,
        _token : $('#csrf_token').val(),
        body   : $('#edit-post').val()
    }
    console.log(url, dataObj);
    $.ajax({
        type: 'POST',
        url:   url,
        data:  dataObj,
    })
    .done(function (msg){
        $(postBody).text(msg['new_body']);
        $('#edit_modal').modal('hide');

    });
});

$('.like').click(function (event) {
   var isliked = $(this).hasClass('isliked');
   var urllike = $('#urllike').val();
   var token = $('#tokenlike').val();
   var postId   = event.target.parentNode.parentNode.dataset['post_id'];
   console.log(isliked,postId);


   $.ajax({
        method : 'POST',
        url : urllike,
        data : {isliked : isliked, postId:postId, _token : token}
   })
   .done(function(msg){
        console.log(msg);
        console.log(event.target);
        if(msg.status === true){
            // $(event.target).removeClass('is-like is-dislike');
            $(event.target).siblings().removeClass('is-like is-dislike');
            $(event.target).removeClass('is-like is-dislike');
            if(msg.like === true && msg.undo === false){
                $(event.target).addClass('is-like');
            }
            else if(msg.like === false && msg.undo === false){
                console.log(111);
                $(event.target).addClass('is-dislike');
            }
        }
   });
   
});
