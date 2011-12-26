$(document).ready(function() {
   $('#contact').submit(function(e) {
       e.preventDefault();
       $.ajax({
         url: $('#contact').attr('action'),
         data: $('#contact').serialize(),
         dataType: 'json',
         type: 'POST',
         success: function(data) {
             alert(data.message);
             return true;
         }
      }).error(function(xhr) {
         alert($.parseJSON(xhr.responseText).error.message);
      });
   })
});