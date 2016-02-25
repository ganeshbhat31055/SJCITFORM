<!-- Copyright GANESH P BHAT -->
<!-- Fully documented code is available, anybody can download or fork me on Github.com at ganeshbhat31055
Happy Coding -->
<!--Have a feedback? mail me at ganeshpnbhat@gmail.com-->

<?php include("INC/header.php"); ?>




             <!--        The content div elements places the form in order styled with CSS   -->


        <?php
        if (($_SERVER[REQUEST_METHOD] == "GET")) {
            ?>

             <!--  displaying the SVG element which animates through paths      -->
            <svg
                xmlns:dc="http://purl.org/dc/elements/1.1/"
                xmlns:cc="http://creativecommons.org/ns#"
                xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                xmlns:svg="http://www.w3.org/2000/svg"
                xmlns="http://www.w3.org/2000/svg"
                width="512"
                height="512"
                viewBox="0 0 512.00001 512.00001"
                id="svg2"
                version="1.1">
               <defs
                  id="defs4" />
               <metadata
                  id="metadata7">
                 <rdf:RDF>
                   <cc:Work
                      rdf:about="">
                     <dc:format>image/svg+xml</dc:format>
                     <dc:type
                        rdf:resource="http://purl.org/dc/dcmitype/StillImage" />
                     <dc:title></dc:title>
                   </cc:Work>
                 </rdf:RDF>
               </metadata>
                         <g class="path">
               <path
                  style="opacity:1;fill:#000000;fill-opacity:0;fill-rule:evenodd;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                  d="M 99.868109,78.35632 C 110.70008,69.69074 468.04349,44.80386 468.04349,44.80386 c 0,0 15.88688,2.16639 26.71885,-20.21967 l -31.77377,59.93686 -131.05413,20.94178 c 0,0 -17.03993,56.30796 -34.45832,98.78756 l 19.64197,-11.4097 -46.93852,135.7607 22.09721,-9.6766 -68.43275,135.22317 10.5759,-104.55867 -12.62314,12.9522 25.27459,-157.4245 -22.38607,23.1082 30.3295,-122.76236 -142.98195,14.44266 c 0,0 -37.701481,1.07673 -49.214751,25.386 0,0 26.21804,-58.2696 37.05,-66.93517 z"
                  id="path3" />
               <path
                  id="path4"
                  d="M 82.064593,95.00919 C 92.896563,86.34361 450.23998,61.45673 450.23998,61.45673 c 0,0 15.88688,2.16639 26.71885,-20.21967 l -31.77377,59.93686 -131.05413,20.94178 c 0,0 -17.03993,56.30796 -34.45832,98.78756 l 19.64197,-11.4097 -46.93852,135.7607 22.09721,-9.6766 -68.43276,135.22318 10.57591,-104.55868 -12.62314,12.9522 25.27459,-157.4245 -22.38607,23.1082 30.3295,-122.76236 -142.981957,14.44266 c 0,0 -37.701478,1.07673 -49.21475,25.386 0,0 26.21804,-58.2696 37.05,-66.93517 z"
                  style="opacity:1;fill:#ffff00;fill-opacity:0;fill-rule:evenodd;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:4;stroke-opacity:1" />
                         </g>
             </svg>
              <div id="message">

              </div>
            <img src="712%20(1).gif" style="display: none;width: 40px;height: 40px;margin: 0 auto" id="load">
              <div id="content">
           <div id="form">
           <form method="post" action="./validate.php" id="eventform">
               <p id="txt">Name:</p>
               <input id="inp" type="text" name="Name"/>
               <p id="txt">USN:</p>
               <input id="inp" type="text" name="Usn"/>
               <p id="txt">Email:</p>
               <input id="inp" type="text" name="Email"/>
               <p id="txt">Phone(don't enter country code):</p>
               <input id="inp" alt="Dont enter country code" type="text" name="Phone"/>
               <p id="txt">Event:</p>
               <select name="Event" id="events" oninput="paper()">
                 <option value="Coding">Coding</option>
                 <option value="Quiz">Quiz</option>
                 <option value="Gaming">Gaming</option>
                 <option value="Paper Presentation">Paper Presentation</option>
               </select>
               <p id="dd" class="txt">DD no:</p>
               <input id="inpdd" alt="Dont enter country code" type="text" name="DDno"/>
               <input type="submit" id="Submit" name="Submit"/>

               </form>
                 </div>
               </div>
              <p id="copy">for any queries email us at technotsav@sjcit.ac.in</p>

                 <!--        The below script tag is used for hiding the elements through jquery and the concept of AJAX  -->
                         <script>
                     // On page load, all elemets of the form, header are hidden and are displayed only after the transition
                          const TIME=5800;
                     $(document).ready(function(){
                         $("#inpdd").hide();
                         $("#dd").hide();
                     jQuery("#svg2").addClass(".path");
                     jQuery("#svg2").delay(5600).fadeOut("fast");
                     jQuery("#content").hide().delay(TIME).fadeIn("fast");
                     jQuery(".header").hide().delay(TIME).fadeIn("fast");
                     jQuery("#copy").hide().delay(TIME).fadeIn("fast");
                         jQuery("#copy1").hide().delay(TIME).fadeIn("fast");
                          });
                        jQuery("#eventform").submit(function (event) {
                            event.preventDefault();
                            var url = $(this).attr("action");
                            var data = $(this).serialize();
                            $('body').scrollTop(0);
                            $("#load").show();
                            $.post(url,data,function(response){
                                if(response.search("<img"))
                                {
                                    $("#form").hide();
                                }
                                $("#message").html(response);
                                $("#load").hide();
                            });


                        });
                     function paper(){
                         if($('#events').find(":selected").text() == "Paper Presentation")
                         {
                             $("#inpdd").show();
                             $("#dd").show();

                         }else {
                             $("#inpdd").hide();
                             $("#dd").hide();
                         }
                     }

                     </script>
                 <?php  } ?>
<!--            Copyright Technotsav styles with CSS -->

<?php include("INC/footer.php"); ?>
