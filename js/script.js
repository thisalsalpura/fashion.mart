function gotoFrofile() {
  window.location = "userProfile.php";
}

function gotoAdvancedSSearch() {
  window.location = "advancedSearch.php";
}

function goToShopping() {
  window.location = "signup&signin.php";
}

function goToUser() {
  window.location = "signup&signin.php";
}

function reloadPage() {
  window.location = "adminPanel.php";
}

function footerLogoReload() {
  window.location = "index.php";
}

function startShopping() {
  window.location = "index.php";
}

// js for loading in all files
document.addEventListener("DOMContentLoaded", function () {
  setTimeout(function () {
    document.getElementById("loading").style.display = "none";

    document.getElementById("main-content").style.display = "block";
  }, 1000);
});

// js for menubtn in products.php
let menuToggle = document.querySelector(".menuToggle");
let menuNavigation = document.querySelector(".menu-navigation");

menuToggle.onclick = function () {
  toggleMenu();
};

function toggleMenu() {
  // js for menubtn in products.php
  menuToggle.classList.toggle("active");
  menuNavigation.classList.toggle("active");

  // js for resposive menu display to all positions in products.php
  let scrollPercentage = (window.scrollY / window.innerHeight) * 100;
  menuNavigation.style.top = `${scrollPercentage}%`;
}

// js froe when scroll hide open ones
window.onscroll = () => {
  // js for menubtn in products.php
  menuToggle.classList.remove("active");
  menuNavigation.classList.remove("active");
};

//js for signup in signup&signin.php
function signup(event) {
  event.preventDefault();

  var fname = document.getElementById("fname");
  var lname = document.getElementById("lname");
  var email = document.getElementById("email");
  var password = document.getElementById("password");
  var mobile = document.getElementById("mobile");
  var gender = document.getElementById("gender");

  var form = new FormData();
  form.append("f", fname.value);
  form.append("l", lname.value);
  form.append("e", email.value);
  form.append("p", password.value);
  form.append("m", mobile.value);
  form.append("g", gender.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;

      if (response == "success") {
        document.getElementById("msg1").innerHTML = "Registation Successfull";
        document.getElementById("msg1").className = "alert alert-success";
        document.getElementById("msgdiv1").className = "d-block";
      } else {
        document.getElementById("msg1").innerHTML = response;
        document.getElementById("msgdiv1").className = "d-block";
      }
    }
  };

  request.open("POST", "signupProcess.php", true);
  request.send(form);
}

//js for signin in signup&signin.php
function signin(event) {
  event.preventDefault();

  var email = document.getElementById("email2");
  var password = document.getElementById("password2");
  var rememberme = document.getElementById("rememberme");

  var form = new FormData();
  form.append("e", email.value);
  form.append("p", password.value);
  form.append("r", rememberme.checked);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;

      if (response == "success") {
        window.location = "index.php";
        document.getElementById("msg").innerHTML = "Sign In Successfull";
        document.getElementById("msg").className = "alert alert-success";
        document.getElementById("msgdiv").className = "d-block";
      } else {
        document.getElementById("msg").innerHTML = response;
        document.getElementById("msg").className = "alert alert-danger";
        document.getElementById("msgdiv").className = "d-block";
      }
    }
  };

  request.open("POST", "signinProcess.php", true);
  request.send(form);
}

//js for home image slider in products.php
document.addEventListener("DOMContentLoaded", function () {
  const slides = document.querySelectorAll(".slider-item");
  const prevBtn = document.getElementById("data-prev-btn");
  const nextBtn = document.getElementById("data-next-btn");
  let currentSlide = 0;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.remove("active");
      if (i === index) {
        slide.classList.add("active");
      }
    });
  }

  function showNextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
  }

  function showPrevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
  }

  setInterval(showNextSlide, 6000);

  nextBtn.addEventListener("click", showNextSlide);
  prevBtn.addEventListener("click", showPrevSlide);
});

// js for backToTop button in products.php
document.addEventListener("DOMContentLoaded", function () {
  var backToTopButton = document.getElementById("backToTop");

  function handleScroll() {
    if (window.scrollY > 20) {
      backToTopButton.classList.add("show");
    } else {
      backToTopButton.classList.remove("show");
    }
  }

  handleScroll();

  window.addEventListener("scroll", handleScroll);

  backToTopButton.addEventListener("click", function () {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  // js for catergories image box slider in products.php
  const slider = document.querySelector(
    ".boxImageSlider .containerBIS [data-slider]"
  );
  const track = slider.querySelector(
    ".boxImageSlider .containerBIS [data-slider-track]"
  );
  const prev = slider.querySelector(
    ".boxImageSlider .containerBIS [data-slider-prev]"
  );
  const next = slider.querySelector(
    ".boxImageSlider .containerBIS [data-slider-next]"
  );

  if (track) {
    prev.addEventListener("click", () => {
      next.removeAttribute("disabled");

      track.scrollTo({
        left: track.scrollLeft - track.firstElementChild.offsetWidth,
        behavior: "smooth",
      });
    });

    next.addEventListener("click", () => {
      prev.removeAttribute("disabled");

      track.scrollTo({
        left: track.scrollLeft + track.firstElementChild.offsetWidth,

        behavior: "smooth",
      });
    });

    track.addEventListener("scroll", () => {
      const trackScrollWidth = track.scrollWidth;
      const trackOuterWidth = track.clientWidth;

      prev.removeAttribute("disabled");
      next.removeAttribute("disabled");

      if (track.scrollLeft <= 0) {
        prev.setAttribute("disabled", "");
      }

      if (track.scrollLeft === trackScrollWidth - trackOuterWidth) {
        next.setAttribute("disabled", "");
      }
    });
  }

  // special category image slider in products.php
  let items = document.querySelectorAll(
    ".product-page .category-deal .slider .list .item"
  );
  let nextCd = document.getElementById("nextCd");
  let prevCd = document.getElementById("prevCd");
  let thumbnails = document.querySelectorAll(
    ".product-page .category-deal .thumbnail .item"
  );

  let countItem = items.length;
  let itemActive = 0;

  nextCd.onclick = function () {
    itemActive = itemActive + 1;
    if (itemActive >= countItem) {
      itemActive = 0;
    }
    showSlider();
  };

  prevCd.onclick = function () {
    itemActive = itemActive - 1;
    if (itemActive < 0) {
      itemActive = countItem - 1;
    }
    showSlider();
  };

  let refreshInterval = setInterval(() => {
    nextCd.click();
  }, 5000);

  function showSlider() {
    let itemActiveOld = document.querySelector(
      ".product-page .category-deal .slider .list .item.active"
    );
    let thumbnailActiveOld = document.querySelector(
      ".product-page .category-deal .thumbnail .item.active"
    );
    itemActiveOld.classList.remove("active");
    thumbnailActiveOld.classList.remove("active");

    items[itemActive].classList.add("active");
    thumbnails[itemActive].classList.add("active");

    clearInterval(refreshInterval);
    refreshInterval = setInterval(() => {
      nextCd.click();
    }, 5000);
  }

  thumbnails.forEach((thumbnail, index) => {
    thumbnail.addEventListener("click", () => {
      itemActive = index;
      showSlider();
    });
  });

  // js for rounded-navbar-div menu button in products.php
  let roundedNavbarIcon = document.querySelector(
    ".product-page .rounded-navbar-div .nav-icons-rnd .menu-icon-rnd"
  );
  let roundedNavbarMenu = document.querySelector(
    ".product-page .rounded-navbar-div .navbar-rnd"
  );

  roundedNavbarIcon.onclick = () => {
    roundedNavbarIcon.classList.toggle("move");
    roundedNavbarMenu.classList.toggle("open-menu");
  };
});

//js for signout in index.php
function signout() {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if (response == "success") {
        window.location.reload();
      }
    }
  };

  request.open("GET", "signOutProcess.php", true);
  request.send();
}

//js for forgot password in signup&signin.php
var forgotPasswordModal;

function forgotPassword() {
  var email = document.getElementById("email2");

  document.getElementById("waiting").style.display = "block";
  document.getElementById("main-content").style.display = "none";

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      document.getElementById("waiting").style.display = "none";
      document.getElementById("main-content").style.display = "block";

      var text = request.responseText;

      if (text == "Success") {
        swal({
          title: "Success",
          text: "Verification code has been sent successfully. Please check your Email",
          icon: "success",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
        var modal = document.getElementById("fpModal");
        forgotPasswordModal = new bootstrap.Modal(modal);
        forgotPasswordModal.show();
      } else {
        swal({
          title: "Error",
          text: text,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
        document.getElementById("msg1").innerHTML = text;
        document.getElementById("msgdiv1").className = "d-block";
      }
    }
  };

  request.open("GET", "forgotPasswordProcess.php?e=" + email.value, true);
  request.send();
}

// js for forgotpassword model show new password in signup&signin.php
function showPassword1() {
  var textfield = document.getElementById("np");
  var button = document.getElementById("npb");

  if (textfield.type == "password") {
    textfield.type = "text";
    button.innerHTML = "Hide";
  } else {
    textfield.type = "password";
    button.innerHTML = "Show";
  }
}

// js for forgotpassword model show re-type password in signup&signin.php
function showPassword2() {
  var textfield = document.getElementById("rnp");
  var button = document.getElementById("rnpb");

  if (textfield.type == "password") {
    textfield.type = "text";
    button.innerHTML = "Hide";
  } else {
    textfield.type = "password";
    button.innerHTML = "Show";
  }
}

// js for resetpassword in signup&signin.php
function resetPassword() {
  var email = document.getElementById("email2");
  var newPassword = document.getElementById("np");
  var retypePassword = document.getElementById("rnp");
  var verification = document.getElementById("vcode");

  var form = new FormData();
  form.append("e", email.value);
  form.append("n", newPassword.value);
  form.append("r", retypePassword.value);
  form.append("v", verification.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if (response == "success") {
        swal({
          title: "Success",
          text: "Password updated successfully.",
          icon: "success",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
        forgotPasswordModal.hide();
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("POST", "resetPasswordProcess.php", true);
  request.send(form);
}

// js for signin section show password in signup&signin.php
function spw2(event) {
  event.preventDefault();

  var textfield = document.getElementById("password2");
  var icon = document.getElementById("eye2");

  if (textfield.type == "password") {
    textfield.type = "text";
    icon.classList = "fa-solid fa-eye hide-unhide";
  } else {
    textfield.type = "password";
    icon.classList = "fa-solid fa-eye-slash hide-unhide";
  }
}

// js for signup section show password in signup&signin.php
function spw1(event) {
  event.preventDefault();

  var textfield = document.getElementById("password");
  var icon = document.getElementById("eye1");

  if (textfield.type == "password") {
    textfield.type = "text";
    icon.classList = "fa-solid fa-eye hide-unhide";
  } else {
    textfield.type = "password";
    icon.classList = "fa-solid fa-eye-slash hide-unhide";
  }
}

// js for profile details password input show password in userProfile.php
function spwprofs(event) {
  event.preventDefault();

  var textfield = document.getElementById("password-profs");
  var icon = document.getElementById("eye-profs");

  if (textfield.type == "password") {
    textfield.type = "text";
    icon.classList = "fa-solid fa-eye hide-unhide-profs";
  } else {
    textfield.type = "password";
    icon.classList = "fa-solid fa-eye-slash hide-unhide-profs";
  }
}

// js for change profile image button in userProfile.php
function changeProfileImg() {
  var img = document.getElementById("profileimage");

  img.onchange = function () {
    var file = this.files[0];
    var url = window.URL.createObjectURL(file);

    document.getElementById("img").src = url;
  };
}

// js for update profile button in userProfile.php
function updateProfile() {
  var fname = document.getElementById("fname");
  var lname = document.getElementById("lname");
  var mobile = document.getElementById("mobile");
  var line1 = document.getElementById("line1");
  var line2 = document.getElementById("line2");
  var province = document.getElementById("province");
  var district = document.getElementById("district");
  var city = document.getElementById("city");
  var pcode = document.getElementById("pcode");
  var image = document.getElementById("profileimage");

  var form = new FormData();
  form.append("f", fname.value);
  form.append("l", lname.value);
  form.append("m", mobile.value);
  form.append("l1", line1.value);
  form.append("l2", line2.value);
  form.append("p", province.value);
  form.append("d", district.value);
  form.append("c", city.value);
  form.append("pc", pcode.value);
  form.append("i", image.files[0]);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if (response == "Updated" || response == "Saved") {
        window.location.reload();
      } else if (response == "You have not selected any image.") {
        swal({
          title: "Success!",
          text: "You have not selected any image.",
          icon: "success",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
        setTimeout(function () {
          window.location.reload();
        }, 1500);
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("POST", "updateProfileProcess.php", true);
  request.send(form);
}

// js for add a product in addProduct.php
function addProduct() {
  var category = document.getElementById("category");
  var brand = document.getElementById("brand");
  var model = document.getElementById("model");
  var title = document.getElementById("title");
  var condition = 0;

  if (document.getElementById("b").checked) {
    condition = 1;
  } else if (document.getElementById("u").checked) {
    condition = 2;
  }

  var clr = document.getElementById("clr");
  var qty = document.getElementById("qty");
  var cost = document.getElementById("cost");
  var dwc = document.getElementById("dwc");
  var doc = document.getElementById("doc");
  var desc = document.getElementById("desc");
  var image = document.getElementById("imageuploader");

  var form = new FormData();
  form.append("ca", category.value);
  form.append("b", brand.value);
  form.append("m", model.value);
  form.append("t", title.value);
  form.append("con", condition);
  form.append("col", clr.value);
  form.append("q", qty.value);
  form.append("co", cost.value);
  form.append("dwc", dwc.value);
  form.append("doc", doc.value);
  form.append("de", desc.value);

  var file_count = image.files.length;

  for (var x = 0; x < file_count; x++) {
    form.append("image" + x, image.files[x]);
  }

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;

      if (response == "success") {
        swal({
          title: "Success",
          text: "Product Saved Successfully.",
          icon: "success",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
        setTimeout(function () {
          window.location.reload();
        }, 1500);
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("POST", "addProductProcess.php", true);
  request.send(form);
}

// js for change product image in addProduct.php
function changeProductImage() {
  var image = document.getElementById("imageuploader");

  image.onchange = function () {
    var file_count = image.files.length;

    if (file_count <= 3) {
      for (var x = 0; x < file_count; x++) {
        var file = this.files[x];
        var url = window.URL.createObjectURL(file);

        document.getElementById("i" + x).src = url;
      }
    } else {
      swal({
        title: "Error",
        text:
          file_count +
          " files. You are proceed to upload only 3 or less than 3 files.",
        icon: "error",
        buttons: {
          confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "swal-ok-button",
            closeModal: true,
          },
        },
        className: "custom-swal",
      });
    }
  };
}

// js for change status in myProducts.php
function changeStatus(id) {
  var product_id = id;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if (response == "deactivated" || response == "activated") {
        window.location.reload();
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("GET", "changeStatusProcess.php?id=" + product_id, true);
  request.send();
}

// js for sort in myProducts.php
function sort1(x) {
  var search = document.getElementById("s");

  var select = document.getElementById("sort-select");

  var time = "0";

  if (document.getElementById("n").checked) {
    time = "1";
  } else if (document.getElementById("o").checked) {
    time = "2";
  }

  var qty = "0";

  if (document.getElementById("h").checked) {
    qty = "1";
  } else if (document.getElementById("l").checked) {
    qty = "2";
  }

  var condition = "0";

  if (document.getElementById("nf").checked) {
    condition = "1";
  } else if (document.getElementById("of").checked) {
    condition = "2";
  }

  var price = "0";

  if (document.getElementById("hp").checked) {
    price = "1";
  } else if (document.getElementById("lp").checked) {
    price = "2";
  }

  var form = new FormData();
  form.append("s", search.value);
  form.append("se", select.value);
  form.append("t", time);
  form.append("q", qty);
  form.append("c", condition);
  form.append("p", price);
  form.append("page", x);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      document.getElementById("sort").innerHTML = response;
    }
  };

  request.open("POST", "sortProcess.php", true);
  request.send(form);
}

// js for clear sort in addProducts.php
function clearSort() {
  window.location.reload();
}

// js for disable the radio btns in addProducts.php
document.addEventListener("DOMContentLoaded", function () {
  function disableRadioButton1() {
    var radioButton1 = document.getElementById("h");
    var radioButton2 = document.getElementById("l");
    var radioButton3 = document.getElementById("hp");
    var radioButton4 = document.getElementById("lp");

    radioButton1.disabled = true;
    radioButton2.disabled = true;
    radioButton3.disabled = true;
    radioButton4.disabled = true;
  }

  document.getElementById("n").addEventListener("click", disableRadioButton1);
  document.getElementById("o").addEventListener("click", disableRadioButton1);

  function disableRadioButton2() {
    var radioButton1 = document.getElementById("n");
    var radioButton2 = document.getElementById("o");
    var radioButton3 = document.getElementById("hp");
    var radioButton4 = document.getElementById("lp");

    radioButton1.disabled = true;
    radioButton2.disabled = true;
    radioButton3.disabled = true;
    radioButton4.disabled = true;
  }

  document.getElementById("h").addEventListener("click", disableRadioButton2);
  document.getElementById("l").addEventListener("click", disableRadioButton2);

  function disableRadioButton3() {
    var radioButton1 = document.getElementById("n");
    var radioButton2 = document.getElementById("o");
    var radioButton3 = document.getElementById("h");
    var radioButton4 = document.getElementById("l");

    radioButton1.disabled = true;
    radioButton2.disabled = true;
    radioButton3.disabled = true;
    radioButton4.disabled = true;
  }

  document.getElementById("hp").addEventListener("click", disableRadioButton3);
  document.getElementById("lp").addEventListener("click", disableRadioButton3);
});

// js for id send to update product in myProducts.php
function sendid(id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;

      if (response == "Success") {
        window.location = "updateProduct.php";
      } else {
        window.location = "myProducts.php";
      }
    }
  };

  request.open("GET", "sendIdProcess.php?id=" + id, true);
  request.send();

  var radioButton1 = document.getElementById("h");
  var radioButton2 = document.getElementById("l");
  var radioButton3 = document.getElementById("n");
  var radioButton4 = document.getElementById("o");
  var radioButton5 = document.getElementById("hp");
  var radioButton6 = document.getElementById("lp");
  var radioButton7 = document.getElementById("nf");
  var radioButton8 = document.getElementById("of");

  radioButton1.checked = false;
  radioButton2.checked = false;
  radioButton3.checked = false;
  radioButton4.checked = false;
  radioButton5.checked = false;
  radioButton6.checked = false;
  radioButton7.checked = false;
  radioButton8.checked = false;
}

// js for update a product in updateProduct.php
function updateProduct() {
  var title = document.getElementById("t");
  var qty = document.getElementById("q");
  var dwc = document.getElementById("dwc");
  var doc = document.getElementById("doc");
  var description = document.getElementById("d");
  var images = document.getElementById("imageuploader");

  var form = new FormData();
  form.append("t", title.value);
  form.append("q", qty.value);
  form.append("dwc", dwc.value);
  form.append("doc", doc.value);
  form.append("d", description.value);

  var file_count = images.files.length;

  for (var x = 0; x < file_count; x++) {
    form.append("i" + x, images.files[x]);
  }

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if (response == "Product has been Updated.") {
        window.location = "myProducts.php";
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("POST", "updateProductProcess.php", true);
  request.send(form);
}

// js for basicSearch in index.php
function basicSearch(x) {
  var txt = document.getElementById("basic_search_txt");
  var select = document.getElementById("basic_search_select");

  var form = new FormData();
  form.append("t", txt.value);
  form.append("s", select.value);
  form.append("page", x);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      document.getElementById("basicSearchResult").innerHTML = response;
    }
  };

  request.open("POST", "basicSearchProcess.php", true);
  request.send(form);
}

// js for search by category in index.php
function loadCategory(clickedCategory) {
  var categoryId = clickedCategory.id;

  var form = new FormData();
  form.append("cid", categoryId);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      document.getElementById("categorySearchResults").innerHTML = response;
    }
  };

  request.open("POST", "loadCategoryResult.php", true);
  request.send(form);
}

// js for clearSearchResult in index.php
function clearSearchResult() {
  window.location.reload();
}

// js for scroll to aboutus section in index.php
function scrollToAboutSection() {
  var aboutSection = document.getElementById("about");
  aboutSection.scrollIntoView({ behavior: "smooth" });
}

// js for advanced search process in advancedSearch.php
function advancedSearch(x) {
  var txt = document.getElementById("t");
  var category = document.getElementById("c1");
  var brand = document.getElementById("b1");
  var model = document.getElementById("m");
  var condition = document.getElementById("c2");
  var color = document.getElementById("c3");
  var from = document.getElementById("pf");
  var to = document.getElementById("pt");
  var sort = document.getElementById("s");

  var form = new FormData();
  form.append("t", txt.value);
  form.append("cat", category.value);
  form.append("b", brand.value);
  form.append("m", model.value);
  form.append("con", condition.value);
  form.append("col", color.value);
  form.append("pf", from.value);
  form.append("pt", to.value);
  form.append("s", sort.value);
  form.append("page", x);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      document.getElementById("view_area").innerHTML = response;
    }
  };

  request.open("POST", "advancedSearchProcess.php", true);
  request.send(form);
}

// js for see a product image in singleProductView.php
document.addEventListener("DOMContentLoaded", function () {
  const allHoverImages = document.querySelectorAll(
    ".single-pr-view-page .hover-container div img"
  );
  const imgContainer = document.querySelectorAll(
    ".single-pr-view-page .img-container-spv"
  );

  window.addEventListener("DOMContentLoaded", () => {
    allHoverImages[0].parentElement.classList.add("single-pr-active");
  });

  allHoverImages.forEach((image) => {
    image.addEventListener("mouseover", () => {
      const targetImg = imgContainer[0].querySelector("img");
      targetImg.src = image.src;
      resetActiveImg();
      image.parentElement.classList.add("single-pr-active");
    });
  });

  function resetActiveImg() {
    allHoverImages.forEach((img) => {
      img.parentElement.classList.remove("single-pr-active");
    });
  }
});

// js for select a qty in singleProductView.php
function qty_inc(qty) {
  var input = document.getElementById("qty_input");

  if (input.innerHTML < qty) {
    var newValue = parseInt(input.innerHTML) + 1;
    input.innerHTML = newValue;
  } else {
    swal({
      title: "Error",
      text: "Maximum quantity has achieved.",
      icon: "error",
      buttons: {
        confirm: {
          text: "OK",
          value: true,
          visible: true,
          className: "swal-ok-button",
          closeModal: true,
        },
      },
      className: "custom-swal",
    });
    input.innerHTML = qty;
  }
}

function qty_dec() {
  var input = document.getElementById("qty_input");

  if (input.innerHTML > 1) {
    var newValue = parseInt(input.innerHTML) - 1;
    input.innerHTML = newValue;
  } else {
    swal({
      title: "Error",
      text: "Minimum quantity has achieved.",
      icon: "error",
      buttons: {
        confirm: {
          text: "OK",
          value: true,
          visible: true,
          className: "swal-ok-button",
          closeModal: true,
        },
      },
      className: "custom-swal",
    });
    input.innerHTML = 1;
  }
}

// js for add to watchlist in all files
function addToWatchlist(id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      var heartIcon = document.getElementById("heart" + id);
      var addButton = document.querySelector(".add-watchlist-btn-not-added");
      var removeButton = document.querySelector(".add-watchlist-btn-added");

      if (response == "Added") {
        heartIcon.classList.remove("not-watchlisted");
        heartIcon.classList.add("watchlisted");
        addButton.classList.remove("add-watchlist-btn-not-added");
        addButton.classList.add("add-watchlist-btn-added");
      } else if (response == "Removed") {
        heartIcon.classList.remove("watchlisted");
        heartIcon.classList.add("not-watchlisted");
        removeButton.classList.remove("add-watchlist-btn-added");
        removeButton.classList.add("add-watchlist-btn-not-added");
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
    setTimeout(function () {
      window.location.reload();
    }, 1000);
  };

  request.open("GET", "addToWatchlistProcess.php?id=" + id, true);
  request.send();
}

// js for remove product in watchlist.php
function removeFromWatchlist(id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if (response == "success") {
        window.location.reload();
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("GET", "removeWatchlistProcess.php?id=" + id, true);
  request.send();
}

// add to cart in all files
function addToCart(id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      var cartIcon = document.getElementById("carti" + id);
      var addButtoncart = document.getElementById("abcarti" + id);
      var removeButtoncart = document.getElementById("rbcarti" + id);
      var addButtoncartw = document.getElementById("abbcarti" + id);
      var removeButtoncartw = document.getElementById("rbbcarti" + id);

      if (response == "New product added to the cart.") {
        cartIcon.classList.remove("not-watchlisted");
        cartIcon.classList.add("watchlisted");
        addButtoncart.classList.remove("add-cart-btn-no");
        addButtoncart.classList.add("add-cart-btn");
        addButtoncartw.classList.remove("atc-btn-no");
        addButtoncartw.classList.add("atc-btn");
      } else if (response == "Product is remove from the cart.") {
        cartIcon.classList.remove("watchlisted");
        cartIcon.classList.add("not-watchlisted");
        removeButtoncart.classList.remove("add-cart-btn");
        removeButtoncart.classList.add("add-cart-btn-no");
        removeButtoncartw.classList.remove("atc-btn");
        removeButtoncartw.classList.add("atc-btn-no");
      } else if (response == "Please update your profile.") {
        window.location = "userProfile.php";
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
    setTimeout(function () {
      window.location.reload();
    }, 1000);
  };

  request.open("GET", "addToCartProcess.php?id=" + id, true);
  request.send();
}

// js for change quantity in cart.php
function upQTY(id, availableQuantity) {
  var qtyInput = document.getElementById("qty_num_" + id);
  var qty = parseInt(qtyInput.innerHTML);

  if (qty < availableQuantity) {
    var newValue = qty + 1;
    qtyInput.innerHTML = newValue;
    updateQuantity(id, newValue);
  } else {
    swal({
      title: "Error",
      text: "Maximum quantity has been reached.",
      icon: "error",
      buttons: {
        confirm: {
          text: "OK",
          value: true,
          visible: true,
          className: "swal-ok-button",
          closeModal: true,
        },
      },
      className: "custom-swal",
    });
  }
}

function downQTY(id) {
  var qtyInput = document.getElementById("qty_num_" + id);
  var qty = parseInt(qtyInput.innerHTML);

  if (qty > 1) {
    var newValue = qty - 1;
    qtyInput.innerHTML = newValue;
    updateQuantity(id, newValue);
  } else {
    swal({
      title: "Error",
      text: "Minimum quantity has been reached.",
      icon: "error",
      buttons: {
        confirm: {
          text: "OK",
          value: true,
          visible: true,
          className: "swal-ok-button",
          closeModal: true,
        },
      },
      className: "custom-swal",
    });
  }
}

// js for update a change quantity in database
function updateQuantity(id, newQty) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      if (response === "Updated") {
        window.location.reload();
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open(
    "GET",
    "cartQtyUpdateProcess.php?qty=" + newQty + "&id=" + id,
    true
  );
  request.send();
}

// js for remove a product in cart.php
function deleteFromCart(id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if ((response = "Removed")) {
        window.location.reload();
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("GET", "deleteFromCardProcess.php?id=" + id, true);
  request.send();
}

// js for payment to product in singlrProductViwe.php
function payNow(id) {
  document.getElementById("waiting2").style.display = "block";

  var qty = document.getElementById("qty_input").innerHTML;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;

      var obj = JSON.parse(response);

      var mail = obj["umail"];
      var amount = obj["amount"];

      if (response == 1) {
        document.getElementById("waiting2").style.display = "none";
        swal({
          title: "Error",
          text: "Please Login.",
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
        setTimeout(function () {
          window.location = "signup&signin.php";
        }, 1500);
      } else if (response == 2) {
        document.getElementById("waiting2").style.display = "none";
        swal({
          title: "Error",
          text: "Please update your profile.",
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
        setTimeout(function () {
          window.location = "userProfile.php";
        }, 1500);
      } else {
        payhere.onCompleted = function onCompleted(orderId) {
          console.log("Payment completed. OrderID : " + orderId);
          swal({
            title: "Success",
            text: "Payment completed. OrderID : " + orderId,
            icon: "success",
            buttons: {
              confirm: {
                text: "OK",
                value: true,
                visible: true,
                className: "swal-ok-button",
                closeModal: true,
              },
            },
            className: "custom-swal",
          });
          document.getElementById("waiting2").style.display = "none";
          setTimeout(function () {
            saveInvoice(orderId, id, mail, amount, qty);
          }, 2000);
        };

        payhere.onDismissed = function onDismissed() {
          document.getElementById("waiting2").style.display = "none";
          console.log("Payment dismissed");
        };

        payhere.onError = function onError(error) {
          document.getElementById("waiting2").style.display = "none";
          console.log("Error:" + error);
        };

        var payment = {
          sandbox: true,
          merchant_id: obj["mid"],
          return_url:
            "http://localhost/fashion.mart/singleProductView.php?id=" + id,
          cancel_url:
            "http://localhost/fashion.mart/singleProductView.php?id=" + id,
          notify_url: "http://sample.com/notify",
          order_id: obj["id"],
          items: obj["item"],
          amount: amount + ".00",
          currency: "LKR",
          hash: obj["hash"],
          first_name: obj["fname"],
          last_name: obj["lname"],
          email: mail,
          phone: obj["mobile"],
          address: obj["address"],
          city: obj["city"],
          country: "Sri Lanka",
          delivery_address: obj["address"],
          delivery_city: obj["city"],
          delivery_country: "Sri Lanka",
          custom_1: "",
          custom_2: "",
        };

        // document.getElementById('payhere-payment').onclick = function (e) {
        payhere.startPayment(payment);
        // };
      }
    }
  };

  request.open("GET", "buyNowProcess.php?id=" + id + "&qty=" + qty, true);
  request.send();
}

// js for payment to all product in cart.php
function checkout(cart_ids, tcost) {
  document.getElementById("waiting2").style.display = "block";

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;

      var obj = JSON.parse(response);

      var mail = obj["umail"];
      var amount = obj["amount"];

      if (response == 1) {
        document.getElementById("waiting2").style.display = "none";
        swal({
          title: "Error",
          text: "Please Login.",
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
        setTimeout(function () {
          window.location = "signup&signin.php";
        }, 1500);
      } else if (response == 2) {
        document.getElementById("waiting2").style.display = "none";
        swal({
          title: "Error",
          text: "Please update your profile.",
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
        setTimeout(function () {
          window.location = "userProfile.php";
        }, 1500);
      } else {
        payhere.onCompleted = function onCompleted(orderId) {
          console.log("Payment completed. OrderID : " + orderId);
          swal({
            title: "Success",
            text: "Payment completed. OrderID : " + orderId,
            icon: "success",
            buttons: {
              confirm: {
                text: "OK",
                value: true,
                visible: true,
                className: "swal-ok-button",
                closeModal: true,
              },
            },
            className: "custom-swal",
          });
          document.getElementById("waiting2").style.display = "none";
        };

        payhere.onDismissed = function onDismissed() {
          document.getElementById("waiting2").style.display = "none";
          console.log("Payment dismissed");
        };

        payhere.onError = function onError(error) {
          document.getElementById("waiting2").style.display = "none";
          console.log("Error:" + error);
        };

        var payment = {
          sandbox: true,
          merchant_id: obj["mid"],
          return_url: "http://localhost/fashion.mart/cart.php",
          cancel_url: "http://localhost/fashion.mart/cart.php",
          notify_url: "http://sample.com/notify",
          order_id: obj["id"],
          items: obj["item"],
          amount: amount + ".00",
          currency: "LKR",
          hash: obj["hash"],
          first_name: obj["fname"],
          last_name: obj["lname"],
          email: mail,
          phone: obj["mobile"],
          address: obj["address"],
          city: obj["city"],
          country: "Sri Lanka",
          delivery_address: obj["address"],
          delivery_city: obj["city"],
          delivery_country: "Sri Lanka",
          custom_1: "",
          custom_2: "",
        };

        // document.getElementById('payhere-payment').onclick = function (e) {
        payhere.startPayment(payment);
        // };
      }
    }
  };

  request.open(
    "GET",
    "cartCheckoutProcess.php?cart_ids=" + cart_ids + "&tcost=" + tcost,
    true
  );
  request.send();
}

// js for display and save invoice for buynow process in sigleProductView.php
function saveInvoice(orderId, id, mail, amount, qty) {
  var form = new FormData();
  form.append("o", orderId);
  form.append("i", id);
  form.append("m", mail);
  form.append("a", amount);
  form.append("q", qty);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;

      if (response == "success") {
        window.location = "invoice.php?id=" + orderId;
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("POST", "saveInvoiceProcess.php", true);
  request.send(form);
}

// js for print a invoice bill in invoice.php
function printInvoice() {
  var restorePage = document.body.innerHTML;
  var page = document.getElementById("invoice_page").innerHTML;
  document.body.innerHTML = page;
  window.print();
  document.body.innerHTML = restorePage;
}

// js for open a feedback modal in purchaseHistory.php
var m;
var ipid;

function addFeedbackOne(id) {
  var feedbackModal = document.getElementById("feedbackmodalOne");

  m = new bootstrap.Modal(feedbackModal);
  ipid = id;
  m.show();
}

// js for add a details for feedback in purchaseHistory.php
var m2;

function saveFeedbackOne() {
  var feedbackModal2 = document.getElementById("feedbackmodalTwo");

  m2 = new bootstrap.Modal(feedbackModal2);
  m.hide();
  m2.show();
}

// js for save feedback details  in purchaseHistory.php
function saveFeedbackTwo() {
  var type = 0;

  if (document.getElementById("type1").checked) {
    type = 1;
  } else if (document.getElementById("type2").checked) {
    type = 2;
  } else if (document.getElementById("type3").checked) {
    type = 3;
  }

  var feedback = document.getElementById("feed");

  var form = new FormData();
  form.append("pid", ipid);
  form.append("t", type);
  form.append("f", feedback.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if (response == "success") {
        swal({
          title: "Success",
          text: "Feedback Saved.",
          icon: "success",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
        m2.hide();
        setTimeout(function () {
          window.location.reload();
        }, 1500);
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("POST", "saveFeedbackProcess.php", true);
  request.send(form);
}

// js for delete a one item in purchaseHistory.php
function deleteOneProduct(id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if ((response = "Removed")) {
        window.location.reload();
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("GET", "deleteOneProductProcess.php?id=" + id, true);
  request.send();
}

// js for delete all products in purchaseHistory.php
function deleteAllProducts() {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if ((response = "Removed")) {
        window.location.reload();
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("GET", "deleteAllProductsProcess.php", true);
  request.send();
}

// js for sent a verification code for email in adminSignin.php
var av;

function adminVerification(event) {
  event.preventDefault();

  var email = document.getElementById("e");
  document.getElementById("waiting").style.display = "block";
  document.getElementById("main-content").style.display = "none";

  var form = new FormData();
  form.append("e", email.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;

      if (response == "Success") {
        swal({
          title: "Success",
          text: "Please take a look at your email to find the VERIFICATION CODE.",
          icon: "success",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
        document.getElementById("waiting").style.display = "none";
        document.getElementById("main-content").style.display = "block";
        var adminVerificationModal =
          document.getElementById("verificationModal");
        av = new bootstrap.Modal(adminVerificationModal);
        av.show();
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
        document.getElementById("waiting").style.display = "none";
        document.getElementById("main-content").style.display = "block";
      }
    }
  };

  request.open("POST", "adminVerificationProcess.php", true);
  request.send(form);
}

// js for verify a user in adminSignin.php
function verify() {
  var code = document.getElementById("vcode");

  var form = new FormData();
  form.append("c", code.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;

      if (response == "success") {
        av.hide();
        window.location = "adminPanel.php";
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("POST", "verificationProcess.php", true);
  request.send(form);
}

// js for block a user in manageUsers.php
function blockUser(email) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if (response == "Cannot find the user. Please try again later.") {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      } else if (response == "Something went wrong") {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      } else {
        swal({
          title: "Success",
          text: response,
          icon: "success",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });

        setTimeout(function () {
          window.location.reload();
        }, 1500);
      }
    }
  };

  request.open("GET", "userBlockProcess.php?email=" + email, true);
  request.send();
}

// js for block product in manageProducts.php
function blockProduct(id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if (response == "Cannot find the product. Please try again later.") {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      } else if (response == "Something went wrong") {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      } else {
        swal({
          title: "Success",
          text: response,
          icon: "success",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });

        setTimeout(function () {
          window.location.reload();
        }, 1500);
      }
    }
  };

  request.open("GET", "productBlockProcess.php?id=" + id, true);
  request.send();
}

// js for view single product view in manageProducts.php
var pm;

function viewProductModal(id) {
  var m = document.getElementById("viewProductModal" + id);
  pm = new bootstrap.Modal(m);
  pm.show();
}

// js for add new category icon in manageProducts.php
var cm;

function addNewCategory() {
  var m = document.getElementById("addCategoryModal");
  cm = new bootstrap.Modal(m);
  cm.show();
}

// js for verify a category in manageProducts.php
var vc;
var e;
var n;

function verifyCategory() {
  document.getElementById("waiting").style.display = "block";
  document.getElementById("main-content").style.display = "none";

  var ncm = document.getElementById("addCategoryVerificationModal");
  vc = new bootstrap.Modal(ncm);

  e = document.getElementById("e").value;
  n = document.getElementById("n").value;

  var form = new FormData();
  form.append("email", e);
  form.append("name", n);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if (response == "Success") {
        document.getElementById("waiting").style.display = "none";
        document.getElementById("main-content").style.display = "block";
        cm.hide();
        vc.show();
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
        document.getElementById("waiting").style.display = "none";
        document.getElementById("main-content").style.display = "block";
      }
    }
  };

  request.open("POST", "addNewCategoryProcess.php", true);
  request.send(form);
}

// js for save a category in manangeProducts.php
function saveCategory() {
  var txt = document.getElementById("txt").value;

  var form = new FormData();
  form.append("t", txt);
  form.append("e", e);
  form.append("n", n);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if (response == "success") {
        vc.hide();
        window.location.reload();
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("POST", "saveCategoryProcess.php", true);
  request.send(form);
}

function scrollToAboutSection() {
  var aboutSection = document.getElementById("about");
  aboutSection.scrollIntoView({ behavior: "smooth" });
}

// js for search process in cart.php
function searchCart() {
  var txt = document.getElementById("ctxt").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      document.getElementById("search_view1").innerHTML = response;

      initializePopovers();
    }
  };

  request.open("GET", "cartSearchProcess.php?txt=" + txt, true);
  request.send();
}

// js for display a popover in cart.php
function initializePopovers() {
  var popoverTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="popover"]')
  );
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl, {
      template:
        '<div class="popover my-popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
    });
  });
}

// js for search process in watchlist.php
function searchWatchlist() {
  var txt = document.getElementById("wtxt").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      document.getElementById("search_view2").innerHTML = response;
    }
  };

  request.open("GET", "watchlistSearchProcess.php?txt=" + txt, true);
  request.send();
}

// js for search process in manageUsers.php
function searchUsers() {
  var txt = document.getElementById("utxt").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      document.getElementById("search_view3").innerHTML = response;
    }
  };

  request.open("GET", "usersSearchProcess.php?txt=" + txt, true);
  request.send();
}

// js for search process in manageProducts.php
function searchProducts() {
  var txt = document.getElementById("ptxt").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      document.getElementById("search_view4").innerHTML = response;
    }
  };

  request.open("GET", "productsSearchProcess.php?txt=" + txt, true);
  request.send();
}

// js for add new color in addProduct.php
function addNewClr() {
  var clr = document.getElementById("newClr").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      if (response == "success") {
        window.location.reload();
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("GET", "addNewClrProcess.php?clr=" + clr, true);
  request.send();
}

// js for open a about us modal in index.php
var abus;

function learnmore() {
  var feedbackModal = document.getElementById("aboutusModal");

  abus = new bootstrap.Modal(feedbackModal);
  abus.show();
}

// js for open a msg modal in manageUsers.php
var mm;
var msgSentUser;

function viewMsgModal() {
  var m = document.getElementById("userMsgModalOne");
  mm = new bootstrap.Modal(m);
  mm.show();
}

var mm2;
var user_details_data;

function openSendAdminMsg() {
  var m = document.getElementById("userMsgModal");
  var msgSentUser = document.getElementById("msgSentUser").value;
  mm2 = new bootstrap.Modal(m);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = JSON.parse(request.responseText);

      if (response.hasOwnProperty("error")) {
        swal({
          title: "Error",
          text: response.error,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
        mm.hide();
      } else {
        var user_details_data = response;

        var modalTitle = document.querySelector(".mtjs");
        modalTitle.textContent =
          user_details_data.fname + " " + user_details_data.lname;

        mm.hide();
        mm2.show();
      }
    }
  };

  request.open(
    "GET",
    "msgSentUserSelectProcess.php?email=" + msgSentUser,
    true
  );
  request.send();
}

// js for open a contact admin modal in header.php
var cam;

function contactAdmin() {
  var m = document.getElementById("contactAdmin");
  cam = new bootstrap.Modal(m);
  cam.show();
  menuToggle.classList.remove("active");
  menuNavigation.classList.remove("active");
}

// js for msg sent in manageUsers.php & index.php
function sendAdminMsg() {
  var txt = document.getElementById("msgtxt");
  var msgSentUser = document.getElementById("msgSentUser").value;

  var form = new FormData();
  form.append("t", txt.value);
  form.append("r", msgSentUser);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if (response == "sent") {
        window.location.reload();
        mm2.hide();
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("POST", "sendAdminMsgProcess.php", true);
  request.send(form);
}

function sendAdminMsgTwo(email) {
  var txt = document.getElementById("msgtxt2");

  var form = new FormData();
  form.append("t", txt.value);
  form.append("r", email);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if (response == "sent") {
        window.location.reload();
        cam.hide();
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("POST", "sendAdminMsgProcess.php", true);
  request.send(form);
}

// js for search by invoice id in mySelling.php
function searchInvoice() {
  var txt = document.getElementById("searchtxt").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      document.getElementById("viewAreaSH").innerHTML = response;
    }
  };

  request.open("GET", "searchInvoiceProcess.php?id=" + txt, true);
  request.send();
}

// js for find selling with a date in mySelling.php & adminPanel.php
function findSellings() {
  var from = document.getElementById("from").value;
  var to = document.getElementById("to").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      document.getElementById("viewAreaSH").innerHTML = response;
    }
  };

  request.open("GET", "findSellingsProcess.php?f=" + from + "&t=" + to, true);
  request.send();
}

function findSellingsAD() {
  var from = document.getElementById("fromAD").value;
  var to = document.getElementById("toAD").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      document.getElementById("sh-result").innerHTML = response;
    }
  };

  request.open("GET", "findSellingsProcessAD.php?f=" + from + "&t=" + to, true);
  request.send();
}

// js for find daily selling in adminPanel.php
function findDailySellings() {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      document.getElementById("sh-result").innerHTML = response;
    }
  };

  request.open("GET", "findDailySellingsProcess.php", true);
  request.send();
}

// js for change invoice status in adminPanel.php
function changeInvoiceStatus(id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;
      if (response == "success") {
        window.location.reload();
      } else {
        swal({
          title: "Error",
          text: response,
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "swal-ok-button",
              closeModal: true,
            },
          },
          className: "custom-swal",
        });
      }
    }
  };

  request.open("GET", "changeInvoiceStatusProcess.php?id=" + id, true);
  request.send();
}

// js for scroll animation in index.php
document.addEventListener("DOMContentLoaded", function () {
  function handleIntersection(entries, observer) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate");
        if (
          entry.target.classList.contains("boxImageSlider") ||
          entry.target.classList.contains("category-deal")
        ) {
          const items = entry.target.querySelectorAll(".slideBIS, .item");
          items.forEach((item, index) => {
            setTimeout(() => {
              item.classList.add("animate");
            }, index * 100);
          });
        }
      } else {
        entry.target.classList.remove("animate");
        if (
          entry.target.classList.contains("boxImageSlider") ||
          entry.target.classList.contains("category-deal")
        ) {
          const items = entry.target.querySelectorAll(".slideBIS, .item");
          items.forEach((item) => {
            item.classList.remove("animate");
          });
        }
      }
    });
  }

  const observer = new IntersectionObserver(handleIntersection, {
    threshold: 0.1,
  });

  const elementsToObserve = document.querySelectorAll(
    ".search-bar, .boxImageSlider, .about-section-pp, .category-deal"
  );
  elementsToObserve.forEach((element) => {
    observer.observe(element);
  });
});