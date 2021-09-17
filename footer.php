
    <!-- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  
      
      <script type="text/javascript">
      
        $(".toggleForms").click(function() {
            
            $("#signUpForm").toggle();
            $("#logInForm").toggle();
            
            
        });
          
          $('#diary').bind('input propertychange', function() {

                $.ajax({
                  method: "POST",
                  url: "updatedatabase.php",
                  data: { content: $("#diary").val() }
                });

        });
      
      
      </script>
      
  </body>
</html>


