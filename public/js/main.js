

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


   $.ajax({
        method : 'POST',
        url : urllike,
        data : {isliked : isliked, postId:postId, _token : token}
   })
   .done(function(msg){
        console.log(msg);
        if(msg.status === true){
            $('#is_like').removeClass('is-like');
            $('#is_dislike').removeClass('is-dislike');
            if(msg.like === true && msg.undo === false){
                $('#is_like').addClass('is-like');
            }
            else if(msg.like === false && msg.undo === false){
                $('#is_dislike').addClass('is-dislike');
            }
        }
   });
   
});
