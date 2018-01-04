<?php 
             if(isset($_POST['SubmitValue']) == "Submit"){
                 createTrans();
                 }
            ?>
<div class="col-md-10">
                <div class="ui inverted dimmer" id="frmLoader">
                <div class="ui indeterminate large text loader">Submitting your transaction. Please wait...</div>
                </div>
    <div class="ui raised segment" id="contentDiv">
               
        <div class="ui teal ribbon label pageLabel"><i class="fa fa-file-o"></i>&nbsp;&nbsp;Create Form</div>

                                        <?php if($_GET['action'] == "Added"){?>
                                        <div class="ui positive message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>Your <?php echo strtolower($_GET['type']); ?> was added successfully!</p>
                                        </div>
                                        <?php } ?>
                                        <?php if($_GET['action'] == "Failed"){?>
                                        <div class="ui negative message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>Your <?php echo strtolower($_GET['type']); ?> failed!</p>
                                          <p>Error Encountered : <?php echo $_GET['err'];?></p>
                                        </div>
                                        <?php } ?>
        <form class="ui form basic segment" id="frmDetails" enctype="multipart/form-data" method="POST" action="">
            <div class="field">
                <label><strong>Type of Service</strong></label>
                <input type="text" name="type" value="<?php echo $_GET['type']; ?>" readOnly>
                <input type="hidden" name="typeval" value="<?php if($_GET['type'] == "Issue/Concern"){echo "1";} if($_GET['type'] == "Request"){echo "2";}?>">
            </div>
            <div class="two fields">
                <div class="field">
                <label>Category</label>
                <select class="ui dropdown" name="transcat" id="transcat" onchange="getSubCat(this.value);">
                    <option value="" selected disabled></option>
                    <?php viewCat(); ?>
                </select>
            </div>
            <div class="field">
                <label>Subcategory</label>
                <select class="ui dropdown" name="transsubcat" id="transsubcat">
                    <option value="" selected disabled></option>
                </select>
            </div>
            </div>
            <div class="field">
                <label>Description</label>
                <textarea rows="4" name="transdesc" id="transdesc"></textarea>
            </div>

             <h5 class="ui horizontal header divider">
                <i class="file outline icon"></i>
                Attachments
            </h5>
            <div class="three fields">                   
            <div class="field">
                <input type="file" name="trnsAttach[]" id="file1">
                <div id="file1err"></div>
                <div id="file1err2"></div>
            </div>
            <div class="field">
                    <input type="file" name="trnsAttach[]" id="file2">
                    <div id="file2err"></div>
                    <div id="file2err2"></div>
            </div>
            <div class="field">
                    <input type="file" name="trnsAttach[]" id="file3">
                    <div id="file3err"></div>
                    <div id="file3err2"></div>
            </div>
            
            </div>

            <div class="ui horizontal header divider"></div>
                <?php 
                    $url = $_SERVER['HTTP_REFERER'];
                    $urlid = substr($url, strrpos($url, '/') + 1);
                 ?>

            <input type="submit" name="SubmitValue" id="btnSubmit" value="Submit" class="ui submit green basic button">
            <div class="ui teal basic button"><a href="<?php echo $urlid; ?>" >Cancel</a></div>
            
            
        </form>
        </div>
    </div>
    <div class="ui horizontal divider"></div> 
     
<!--#########################################################   SCRIPTS  ######################################################################################-->

<script type="text/javascript"> 
 function getSubCat(str)
{
    $.ajax({
        url : 'selsubcat.php',
        type : 'GET',
        data : {
            "q" : str
        },
        success : function(data){
            $('#transsubcat').html(data);
        }
    });
   
}

</script>


     <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('#frmDetails')
                                                  .form({
                                                    inline : true,
                                                    on: 'blur',
                                                    fields: {
                                                      category: {
                                                        identifier  : 'transcat',
                                                        rules: [
                                                          {
                                                            type   : 'empty',
                                                            prompt : 'Please select category.'
                                                          }
                                                        ]
                                                      },
                                                      subcategory:{
                                                        identifier  : 'transsubcat',
                                                        rules: [{
                                                            type : 'empty',
                                                            prompt : 'Please select Sub-Category.'
                                                        }]
                                                      },
                                                      description:{
                                                        identifier : 'transdesc',
                                                        rules:[{
                                                            type    : 'empty',
                                                            prompt  : 'Please fill up description.'
                                                        },
                                                        {
                                                            type   : 'maxLength[500]',
                                                            prompt : 'Description is maximum of 500 characters only'
                                                        }
                                                        ]
                                                      }
                                                    },
                                                    onSuccess : function(){
                                                        $('#btnSubmit').addClass("disabled");
                                                        $('#frmLoader').addClass("active");
                                                    }
                                                  });
                                    
                                    });

                        </script>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $('#notif')
                                  .on('click', function() {
                                    $(this)
                                      .closest('.message')
                                      .transition('fade')
                                    ;
                                  })
                                ;

                                $('#notif').delay(7000).slideUp(1000);

                                 $('#Attachnotif')
                                      .on('click', function() {
                                        $(this)
                                          .closest('.message')
                                          .transition('fade')
                                        ;
                                      })
                                    ;

                            $('#Attachnotif').delay(5000).slideUp(1000);


                            });
                            
                        </script>

        <script type="text/javascript">
                 $(document).ready(function(){

                        $('#file1').bind('change', function(){
                            var file1size = this.files[0].size/1024/1024;
                            var file1type = document.getElementById("file1").value; 
                            var file1EXT = file1type.split('.');
                            var file1Final = file1EXT[file1EXT.length - 1];
                                if(file1size > 1){
                                document.getElementById("file1err").innerHTML = "<small style='color:#ff0000'>File attachment should be less than 1 MB.</small>";
                                document.getElementById("file1").value = "";
                                }else{
                                document.getElementById("file1err").innerHTML = "";    
                                    }
                                if(file1Final == "exe" || file1Final == "php" || file1Final == "js" || file1Final == "asp" || file1Final == "vbs"){
                                    document.getElementById("file1err2").innerHTML = "<small style='color:#ff0000'>File attachment cannot be an exe or script.</small>";
                                    document.getElementById("file1").value = "";   
                                }
                                else{
                                    document.getElementById("file1err2").innerHTML = "";  
                                }
                        });

                        $('#file2').bind('change', function() {
                            var file2size = this.files[0].size/1024/1024;
                            var file2type = document.getElementById("file2").value; 
                            var file2EXT = file2type.split('.');
                            var file2Final = file2EXT[file2EXT.length - 1];
                                if(file2size > 1){
                                document.getElementById("file2err").innerHTML = "<small style='color:#ff0000'>File attachment should be less than 1 MB.</small>";
                                document.getElementById("file2").value = "";
                                }else{
                                document.getElementById("file2err").innerHTML = "";    
                                    }

                                if(file2Final == "exe" || file2Final == "php" || file2Final == "js" || file2Final == "asp" || file2Final == "vbs"){
                                    document.getElementById("file2err2").innerHTML = "<small style='color:#ff0000'>File attachment cannot be an exe or script.</small>";
                                    document.getElementById("file2").value = "";   
                                }
                                else{
                                    document.getElementById("file2err2").innerHTML = "";  
                                }
                        });

                        $('#file3').bind('change', function() {
                            var file3size = this.files[0].size/1024/1024;
                            var file3type = document.getElementById("file3").value; 
                            var file3EXT = file3type.split('.');
                            var file3Final = file3EXT[file3EXT.length - 1];
                                if(file3size > 1){
                                document.getElementById("file3err").innerHTML = "<small style='color:#ff0000'>File attachment should be less than 1 MB.</small>";
                                document.getElementById("file3").value = "";
                                }else{
                                document.getElementById("file3err").innerHTML = "";    
                                    }

                                if(file3Final == "exe" || file3Final == "php" || file3Final == "js" || file3Final == "asp" || file3Final == "vbs"){
                                    document.getElementById("file3err2").innerHTML = "<small style='color:#ff0000'>File attachment cannot be an exe or script.</small>";
                                    document.getElementById("file3").value = "";   
                                }
                                else{
                                    document.getElementById("file3err2").innerHTML = "";  
                                }
                            });
                        });


                
        </script>