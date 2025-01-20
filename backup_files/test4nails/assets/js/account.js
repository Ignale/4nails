$("#goToLoginBtn").click(
    (e) => {

        e.preventDefault();
        Fancybox.show([
                {
                    closeExisting: true,
                    src: "#goToLoginForm",
                    type: "inline"
                }],
            {
                on: {

                    destroy: (fancybox, slide) => {

                    },
                },
            }
        );
    }
);
$('#accountLogIn').click(()=>{
    createCookie("returnToCancelOrder", window.location.href, 1);
});

$("#cancel-order-btn").click(
    (e) => {
        e.preventDefault();
        Fancybox.show([
                {
                    closeExisting: true,
                    src: "#cancel-order-modal",
                    type: "inline"
                }],
            {
                on: {

                    destroy: (fancybox, slide) => {

                    },
                },
            }
        );
    }
);

console.log(123123123123123)

