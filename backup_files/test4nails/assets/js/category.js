if (bodyClass('archive') && window.matchMedia('(max-width: 767px)').matches) {


        const box = document.querySelectorAll('.product-card');

        document.addEventListener('scroll', function () {
            showPointer(box)
        }, {
            passive: true
        });

    document.addEventListener('DOMContentLoaded', function () {
        showPointer()
    }, {
        passive: true
    });
    function isInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)

        );
    }




    function showPointer(box){
        box.forEach((item)=>{
            let current= item.querySelector('.products__img');
            if(isInViewport(item)){
                current.classList.add('show-pointer');
            }else {
                if(current.classList.contains('show-pointer'))
                    current.classList.remove('show-pointer');
            }
        });
    }


}