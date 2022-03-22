(function($) {
  'use strict';
  $(function() {
    var todoListItem = $('.todo-list');
    var todoListInput = $('.todo-list-input');
    var inputHelper = $('.input-helper');
    $('.todo-list-add-btn').on("click", function(event) {
      event.preventDefault();

      var item = $(this).prevAll('.todo-list-input').val();
      if (item) {
        //
         $.ajax({
            url: murl + '/todo-list',
            type: "post",
            data: {'todoList': item, '_token': $('input[name=_token]').val()},
            success: function(data){
               location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('An error occurred! Looks like your session has expired or you are not connected to the internet.');
            }
        })
        //
        todoListItem.append("<li><div class='form-check'><label class='form-check-label'><input class='checkbox' type='checkbox'/>" + item + "<i class='input-helper'></i></label></div><i class='remove icon-close'></i></li>");
        todoListInput.val("");
      }

    });

    todoListItem.on('change', '.checkbox', function() {
      if ($(this).attr('checked')) {
        $(this).removeAttr('checked');
      } else {
        $(this).attr('checked', 'checked');
      }

      $(this).closest("li").toggleClass('completed');

    });

    todoListItem.on('click', '.remove', function() {
      var getID        = this.id;
      //
        if(confirm('Are you sure you want to remove this record permanently?'))
        {
           $.ajax({
              url: murl + '/remove-todo-list',
              type: "post",
              data: {'todoListID': getID, '_token': $('input[name=_token]').val()},
              success: function(data){
                $('.remove-parent' + getID).parent().remove();
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert('An error occurred! Looks like your session has expired or you are not connected to the internet.');
              }
          })
        }
        //----//--
    });



    $(".turnOnOff").click(function() {
          var checkedID   = this.id;
          // 
        $.ajax({
            url: murl + '/flag-todo-list',
            type: "post",
            data: {'checkedID': checkedID, '_token': $('input[name=_token]').val()},
            success: function(data){
              //location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('An error occurred! Looks like your session has expired or you are not connected to the internet.');
            }
        })
    });//end function

  });
})(jQuery);