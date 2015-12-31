function getReportsContent() {
    $("#" + contentId).load( htmlContent + "admin_report_static.html", function() {
        $(".create-booking-modal-trigger").leanModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            ready: function() { 
                loadBookingFormData("create-booking-room", "create-booking-user", "create-booking-button");
            }, // Callback for Modal open
            complete: function() { 
                document.getElementById("create-booking-form").reset();
            }
        });
        
        document.getElementById("create-booking-course").onchange = function() {validateBookingCourse("create-booking-course", "create-booking-course-label");};
        document.getElementById("create-booking-button").onclick = function() {validateBookingForm("create-booking-room", "create-booking-user", "create-booking-course", "create-booking-start", "create-booking-end", "create-booking-date", "create-booking-type-makeup", "create-booking-type-advanced-makeup", "create-booking-type-other", "create-booking-modal", "create-booking-form", "include/ajaxRegisterBooking.php");};


        var searchUsername = document.getElementById("search-booking-username");
        var searchRoom = document.getElementById("search-booking-room");
        searchUsername.onkeyup = function() {
            updateBookingList(0, pagination, searchUsername.value, searchRoom.value); 
        };
        
        searchRoom.onkeyup = function() {
            updateBookingList(0, pagination, searchUsername.value, searchRoom.value); 
        };

        updateBookingList(0, pagination, searchUsername.value, searchRoom.value); 
        
    });
    
} 