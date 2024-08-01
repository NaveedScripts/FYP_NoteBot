


$(function () {
  $(".call_signup_tab").click(function () {
    $(".signin_tab").hide();
    $(".signup_tab").show();
});

$(".call_signin_tab").click(function () {
    $(".signin_tab").show();
    $(".signup_tab").hide();
});


});



$(function () {

    $("form[name='registration']").validate({
        rules: {
            firstname: "required",
            lastname: "required",
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            }
        },

        messages: {
            firstname: "Please enter your firstname",
            lastname: "Please enter your lastname",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            email: "Please enter a valid email address"
        },

        submitHandler: function (form) {
            form.submit();
        }
    });
});
