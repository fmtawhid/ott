import 'bootstrap';
import { Tooltip } from 'bootstrap';
import jquery from 'jquery';
import Snackbar from 'node-snackbar';
import 'node-snackbar/dist/snackbar.css';
(function (jQuery) {
  "use strict";
  jQuery(document).ready(function () {
    toolTip();
    backToTop();
    const isRTL = document.documentElement.getAttribute('dir') === 'rtl';
    slickGeneral(isRTL);
    slickBanner(isRTL);
    customSlider(isRTL);
    readmore();

    const selectProfileModal = document.getElementById('selectProfileModal');
    if(selectProfileModal !== null) {
        selectProfileModal.addEventListener('shown.bs.modal', event => {
            selectProfileSlider(isRTL);
        });
    } else {
        console.warn("Element with ID 'selectProfileModal' not found.");
    }
  });
})(jQuery);


// tooltip
function toolTip() {
    // Tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl))
}

// readmore text
function readmore() {
    let buttons = document.querySelectorAll('.readmore-btn');
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            let parent = button.closest('.readmore-wrapper');
            let readmoreText = parent.querySelector('.readmore-text');


            if (readmoreText.classList.contains('active')) {
                readmoreText.classList.remove('active');
                button.innerText = "Read More";
                button.classList.remove('bg-primary')
                button.classList.add('bg-dark')
            } else {
                readmoreText.classList.add('active');
                button.innerText = "Read Less";
                button.classList.remove('bg-dark')
                button.classList.add('bg-primary')
            }
        })
    });
}


// back to top
function backToTop() {
    const backToTop = document.getElementById("back-to-top");
    if (backToTop !== null && backToTop !== undefined) {
        backToTop.classList.add("animate__animated", "animate__fadeOut");
        window.addEventListener("scroll", (e) => {
            if (document.documentElement.scrollTop > 250) {
                backToTop.classList.remove("animate__fadeOut");
                backToTop.classList.add("animate__fadeIn");
            } else {
                backToTop.classList.remove("animate__fadeIn");
                backToTop.classList.add("animate__fadeOut");
            }
        });
        // scroll body to 0px on click
        document.querySelector("#top").addEventListener("click", (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: "smooth" });
        });
    }
}

// general slider
function slickGeneral(isRTL) {
    jQuery('.slick-general').each(function () {
        let slider = jQuery(this);
        let slideSpacing = slider.data("spacing");

        function addSliderSpacing(spacing) {
            slider.css('--spacing', `${spacing}px`);
        }

        addSliderSpacing(slideSpacing);

        slider.slick({
            slidesToShow: slider.data("items"),
            slidesToScroll: 1,
            speed: slider.data("speed"),
            autoplay: slider.data("autoplay"),
            centerMode: slider.data("center"),
            infinite: slider.data("infinite"),
            arrows: slider.data("navigation"),
            dots: slider.data("pagination"),
            prevArrow: "<span class='slick-arrow-prev'><span class='slick-nav'><i class='ph ph-caret-left'></i></span></span>",
            nextArrow: "<span class='slick-arrow-next'><span class='slick-nav'><i class='ph ph-caret-right'></i></span></span>",
            rtl: isRTL,
            responsive: [
                {
                    breakpoint: 1600, // screen size below 1600
                    settings: {
                        slidesToShow:  slider.data("items-desktop"),
                    }
                },
                {
                    breakpoint: 1400, // screen size below 1400
                    settings: {
                        slidesToShow:  slider.data("items-laptop"),
                    }
                },
                {
                    breakpoint: 1200, // screen size below 1200
                    settings: {
                        slidesToShow:  slider.data("items-tab"),
                    }
                },
                {
                    breakpoint: 768, // screen size below 768
                    settings: {
                        slidesToShow:  slider.data("items-mobile-sm"),
                    }
                },
                {
                    breakpoint: 576, // screen size below 576
                    settings: {
                        slidesToShow:  slider.data("items-mobile"),
                    }
                }
            ]
        });

        let active = slider.find(".slick-active");
        let slideItems = slider.find(".slick-track .slick-item");
        active.first().addClass("first");
        active.last().addClass("last");

        slider.on('afterChange', function (event, slick, currentSlide, nextSlide) {
            let active = slider.find(".slick-active");
            slideItems.removeClass("first last");
            active.first().addClass("first");
            active.last().addClass("last");
        });
    });
}

// banner slider
function slickBanner(isRTL) {
    jQuery('.slick-banner').each(function () {
        let bannerSlider = jQuery(this);
        let slideSpacing = bannerSlider.data("spacing");

        function addSliderSpacing(spacing) {
            bannerSlider.css('--spacing', `${spacing}px`);
        }

        addSliderSpacing(slideSpacing);

        bannerSlider.slick({
            fade: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            speed: bannerSlider.data("speed"),
            autoplay: bannerSlider.data("autoplay"),
            centerMode: bannerSlider.data("center"),
            infinite: bannerSlider.data("infinite"),
            arrows: bannerSlider.data("navigation"),
            dots: bannerSlider.data("pagination"),
            prevArrow: "<span class='slick-arrow-prev'><i class='ph ph-caret-left'></i></span>",
            nextArrow: "<span class='slick-arrow-next'><i class='ph ph-caret-right'></i></span>",
            rtl: isRTL,
        });
    })
}

// select profile slider
function selectProfileSlider(isRTL) {
    jQuery('.select-profile-slider').slick({
        centerMode: true,
        centerPadding: '0',
        slidesToShow: 3,
        infinite: false,
        focusOnSelect: true,
        rtl: isRTL,
        arrows: false,
        dots: false,
        responsive: [
            {
                breakpoint: 564,
                settings: {
                    slidesToShow:  1,
                    dots: true,
                }
            }
        ]
    })
}

// custom slider
function customSlider(isRTL) {
    if (document.querySelectorAll(".custom-nav-slider").length) {
        const sliders = document.querySelectorAll('.custom-nav-slider');

        function slide(direction, e) {
            const container = e.target.closest("div").parentElement.getElementsByClassName("custom-nav-slider");
            const parent = e.target.closest("div").parentElement;
            slidescroll(container, direction, parent);
        }

        function slidescroll(container, direction, parent, is_vertical = false) {
            let scrollCompleted = 0;
            const rightArrow = parent ? parent.getElementsByClassName("right")[0] : null;
            const leftArrow = parent ? parent.getElementsByClassName("left")[0] : null;
            const maxScroll = parent ? container[0].scrollWidth - container[0].offsetWidth - 30 : null;

            const slideVar = setInterval(() => {
                if (direction === 'left') {
                    if (is_vertical) {
                        container[0].scrollTop -= 5;
                    } else {
                        container[0].scrollLeft -= 20;
                    }
                    if (parent) {
                        rightArrow.style.display = "block";
                        if (container[0].scrollLeft === 0)
                            leftArrow.style.display = "none";
                    }
                } else {
                    if (is_vertical) {
                        container[0].scrollTop += 5;
                    } else {
                        container[0].scrollLeft += 20;
                    }
                    if (parent) {
                        leftArrow.style.display = "block";
                        if (container[0].scrollLeft > maxScroll)
                            rightArrow.style.display = "none";
                    }
                }
                scrollCompleted += 10;
                if (scrollCompleted >= 100) {
                    clearInterval(slideVar);
                }
            }, 40);
        }

        function enableSliderNav() {
            sliders.forEach((element) => {
                const left = element.parentElement.querySelector(".left");
                const right = element.parentElement.querySelector(".right");

                if (element.scrollWidth - element.clientWidth > 0) {
                    right.style.display = "block";
                    left.style.display = "block";
                } else {
                    right.style.display = "none";
                    left.style.display = "none";
                }

                // Attach event listeners to the left and right arrows
                if (left && right) {
                    left.addEventListener('click', (e) => slide('left', e));
                    right.addEventListener('click', (e) => slide('right', e));
                }
            });
        }

        function slideDrag(eslider) {
            let isDown = false;
            let startX;
            let scrollLeft;
            const maxScroll = eslider.scrollWidth - eslider.clientWidth - 20;
            const rightArrow = eslider.parentElement.getElementsByClassName("right")[0];
            const leftArrow = eslider.parentElement.getElementsByClassName("left")[0];

            eslider.addEventListener('mousedown', (e) => {
                isDown = true;
                eslider.classList.add('active');
                startX = e.pageX - eslider.offsetLeft;
                scrollLeft = eslider.scrollLeft;
            });

            eslider.addEventListener('mouseleave', () => {
                isDown = false;
                eslider.classList.remove('active');
            });

            eslider.addEventListener('mouseup', () => {
                isDown = false;
                eslider.classList.remove('active');
            });

            eslider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - eslider.offsetLeft;
                const walk = (x - startX) * 3; //scroll-fast
                eslider.scrollLeft = scrollLeft - walk;

                if (eslider.scrollLeft > maxScroll) {
                    rightArrow.style.display = "none";
                } else {
                    leftArrow.style.display = eslider.scrollLeft === 0 ? "none" : "block";
                    rightArrow.style.display = "block";
                }
            });
        }

        // Initialize slider drag and navigation
        sliders.forEach((element) => {
            slideDrag(element);
        });
        enableSliderNav();

        // Re-enable navigation on resize
        window.addEventListener('resize', enableSliderNav);
    }
}
const snackbarMessage = () => {
    const PRIMARY_COLOR = window.getComputedStyle(document.querySelector('html')).getPropertyValue('--bs-success').trim()
    const DANGER_COLOR = window.getComputedStyle(document.querySelector('html')).getPropertyValue('--bs-danger').trim()

    const successSnackbar = (message) => {
        Snackbar.show({
            text: message,
            pos: 'bottom-left',
            actionTextColor: PRIMARY_COLOR,
            duration: 2500
        })
    }
    window.successSnackbar = successSnackbar

    const errorSnackbar = (message) => {
        Snackbar.show({
            text: message,
            pos: 'bottom-left',
            actionTextColor: '#FFFFFF',
            backgroundColor: DANGER_COLOR,
            duration: 2500
        })
    }
    window.errorSnackbar = errorSnackbar
  }
  snackbarMessage()


  function formatCurrency(number, noOfDecimal, decimalSeparator, thousandSeparator, currencyPosition, currencySymbol) {
    // Convert the number to a string with the desired decimal places
    let formattedNumber = number.toFixed(noOfDecimal)

    // Split the number into integer and decimal parts
    let [integerPart, decimalPart] = formattedNumber.split('.')

    // Add thousand separators to the integer part
    integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, thousandSeparator)

    // Set decimalPart to an empty string if it is undefined
    decimalPart = decimalPart || ''

    // Construct the final formatted currency string
    let currencyString = ''

    if (currencyPosition === 'left' || currencyPosition === 'left_with_space') {
      currencyString += currencySymbol
      if (currencyPosition === 'left_with_space') {
        currencyString += ' '
      }
      currencyString += integerPart
      // Add decimal part and decimal separator if applicable
      if (noOfDecimal > 0) {
        currencyString += decimalSeparator + decimalPart
      }
    }

    if (currencyPosition === 'right' || currencyPosition === 'right_with_space') {
      // Add decimal part and decimal separator if applicable
      if (noOfDecimal > 0) {
        currencyString += integerPart + decimalSeparator + decimalPart
      }
      if (currencyPosition === 'right_with_space') {
        currencyString += ' '
      }
      currencyString += currencySymbol
    }

    return currencyString
  }

  window.formatCurrency = formatCurrency
