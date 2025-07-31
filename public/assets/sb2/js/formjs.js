let form = document.getElementById("regForm"),
    csrfToken =
        (document.querySelector('[name="csrf-token"]') &&
            document.querySelector('[name="csrf-token"]').content) ||
        "",
    pwdd;
form &&
    form.addEventListener("submit", async function (e) {
        e.preventDefault();
        if (!$("#regForm").valid()) return false;

        const $callback = $("#regForm[callbackFn]");
        const $callbackAfterSuccess = $("#regForm[callbackSuccessFn]");
        if ($callback && $callback.attr("callbackFn")) {
            const Fn = $callback.attr("callbackFn");
            const callbackRes = await window[Fn]();
            if (!callbackRes) {
                typeof callbackErrorMessage !== "undefined" &&
                    toastr.error(callbackErrorMessage);
                return false;
            }
        }

        const button = this.querySelector("[type=submit]");
        const forms = this;
        const buttonText = button.innerHTML;
        startLoadings(button);
        await delay(1000);
        const formData = new FormData(form);
        form && $("select,input,textarea", form).attr("disabled", true);
        var url = this.action;

        try {
            const res = await makeHttpRequest(
                url,
                form?.nethod || "post",
                formData
            );
            if (res.success) {
                stopLoadings(button, buttonText);

                if (res?.tableReload) {
                    table?.ajax && table.ajax.reload();
                }

                if (res.confirmation) {
                    Swal.fire({
                        title: "Are You Sure",
                        text: res.success,
                        icon: "warning",
                        allowOutsideClick: false,
                        showCancelButton: true,
                        confirmButtonText: "Yes",
                        cancelButtonText: "No"
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            // Recreate FormData and add 'conform'
                            const formDataConfirmed = new FormData(form);
                            formDataConfirmed.append("conform", "yes");

                            // Optional: disable inputs again if needed
                            form && $("select,input,textarea", form).attr("disabled", true);
                            startLoadings(button, "Submitting again...");

                            // Send again
                            const confirmRes = await makeHttpRequest(url, form?.method || "post", formDataConfirmed);

                            // Handle confirmRes just like you handle res
                            if (confirmRes.success) {
                                toastr.success(confirmRes.success);
                                form.reset();

                                
                                    table?.ajax && table.ajax.reload();
                                

                                 await window["closeModal"]();
                            } else {
                                if (res.validationError) {
                                    const error = res.validationError;

                                    if (typeof error === 'string') {
                                        // Single error message as string (e.g., SQL error)
                                        toastr.error(error);
                                    } else if (typeof error === 'object') {
                                        // Laravel-style validation errors (object with arrays or strings)
                                        Object.keys(error).forEach((key) => {
                                            if (Array.isArray(error[key])) {
                                                error[key].forEach((msg) => toastr.error(msg));
                                            } else if (typeof error[key] === 'string') {
                                                toastr.error(error[key]);
                                            }
                                        });
                                    }
                                }
                            }

                            stopLoadings(button, buttonText);
                            form && $("select,input,textarea", form).removeAttr("disabled");
                        }
                    });
                    return;
                }


                if (res.sweetAlert) {
                    try {
                        Swal.fire({
                            title: "Successful",
                            text: res.success,
                            icon: "success",
                            allowOutsideClick: false,
                        }).then(async (result) => {
                            if (result.isConfirmed) {
                                res.redirectConfirmation &&
                                    (await confirmation(res));
                                window.scrollTo({
                                    top: 10,
                                });
                                if (res?.redirect) {
                                    toastr.success("Redirecting...");
                                    setTimeout(() => {
                                        window.location = res.redirect;
                                    }, 1500);
                                }
                            }
                        });

                        try {
                            if (typeof closeBtn !== undefined) closeBtn.click();
                        } catch (error) { }
                    } catch (error) {
                        alert(error);
                    }
                } else {
                    toastr.success(res.success);
                }

                if (res.reloadReq) {
                    window.scrollTo({
                        top: 0,
                        behavior: "smooth",
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
                forms.reset();

                if (
                    $callbackAfterSuccess &&
                    $callbackAfterSuccess.attr("callbackSuccessFn")
                ) {
                    const Fn = $callbackAfterSuccess.attr("callbackSuccessFn");
                    const callbackResSuccess = await window[Fn]();
                    if (!callbackResSuccess) {
                        typeof callbackResSuccess !== "undefined" &&
                            toastr.error(callbackResSuccess);
                        return false;
                    }
                }
            } else if (res.message) {
                toastr.error(res.message);
            }

            if (res.error) {
                toastr.error(res.error);
            }

            // if (res.validationError) {
            //     Object.keys(res.validationError).forEach((message) => {
            //         toastr.error(res.validationError[message]);
            //     });
            // }

            if (res.validationError) {
                const error = res.validationError;

                if (typeof error === 'string') {
                    // Single error message as string (e.g., SQL error)
                    toastr.error(error);
                } else if (typeof error === 'object') {
                    // Laravel-style validation errors (object with arrays or strings)
                    Object.keys(error).forEach((key) => {
                        if (Array.isArray(error[key])) {
                            error[key].forEach((msg) => toastr.error(msg));
                        } else if (typeof error[key] === 'string') {
                            toastr.error(error[key]);
                        }
                    });
                }
            }



            if (res.validationErrorToastr) {
                Object.keys(res.validationErrorToastr).forEach((message) => {
                    toastr.error(res.validationErrorToastr[message]);
                });
            }

            if (!res.success && res.redirect) {
                toastr.success("Redirecting...");
                setTimeout(() => {
                    window.location = res.redirect;
                }, 1500);
            }

            if (res.csrfToken) $("input[type=hidden]").val(res.csrfToken);
        } catch (error) {
            toastr.error(error);
        }
        form && $("select,input,textarea", form).removeAttr("disabled");
        stopLoadings(button, buttonText);
    });

/*async function makeHttpRequest(url,method,data){
  const res = await fetch(url, {
    method: method,
    body: data
  })

  if (!res.ok) {
    console.log(res);
      throw new Error(res.statusText);
    }

     try {
        return await res.json();
    } catch (error) {

        let resText;
        try {
            resText = await res.text();
        } catch (textError) {
          console.log(textError)
            throw new Error(textError);
        }
        throw new Error(resText ? resText : 'Invalid JSON response');
    }
} */

async function makeHttpRequest(url, method, data, csrf = false) {
    let res, resText, config;

    config = csrf
        ? {
            method: method,
            body: data,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
        }
        : {
            method: method,
            body: data,
            headers: { Accept: "application/json" },
        };
    try {
        if (method.toLowerCase() == "post") {
            res = await fetch(url, config);
        } else {
            res = await fetch(url);
        }

        if (!res.ok) {
            return await res.json();
        }

        return await res.json();
    } catch (error) {
        try {
            resText = await res.text(); // Read the text from the cloned response
        } catch (textError) {
            console.log(textError);
            throw new Error("Error getting response text:", textError);
        }
        console.log(resText.slice(0, 20));
        throw new Error(removeHtmlTags(resText.slice(0, 500)));
    }
}

function removeHtmlTags(text) {
    /* // Regular expression to match HTML tags
     const htmlRegex = /<[^>]*>/g;
     // Replace HTML tags with an empty string
     return text.replace(htmlRegex, '');*/
    // Remove HTML tags
    text = text.replace(/<[^>]+>/g, "");

    // Remove HTML comments
    text = text.replace(/<!--[\s\S]*?-->/g, "");
    text = text.replace(/<!--/g, "");
    return text;
}

function validate2() {
    const enKey = $('input[name="_token"]').val();
    //alert('sdf');
    if (enKey != "") {
        let pwdObj = password;
        let hashObj = new jsSHA("SHA-512", "TEXT", {
            numRounds: 1,
        });
        hashObj.update(pwdObj.value);
        let hash = hashObj.getHash("HEX");
        console.log(hash, "first hash");
        let hmacObj = new jsSHA("SHA-512", "TEXT");
        hmacObj.setHMACKey(enKey, "TEXT");
        hmacObj.update(hash);
        pwdd = hmacObj.getHMAC("HEX");
        return true;
    } else {
        return false;
    }
}

//for input type number icon remove

$(document).ready(function () {
    $(document).on("keypress", ".num", function () {
        if ($(this).val().length == $(this).attr("maxlength")) {
            return false;
        }
    });

    $(document).on("keypress", ".num[type=number]", function (event) {
        return (
            event.keyCode === 8 ||
            (event.charCode >= 48 && event.charCode <= 57)
        );
    });

    $(document).on("keypress", ".allowDot[type=number]", function (event) {
        return (
            event.charCode === 46 ||
            (event.charCode >= 48 && event.charCode <= 57)
        );
    });

    $(".alphaSpace").keypress(function () {
        return (
            (event.keyCode >= 65 && event.keyCode <= 90) ||
            (event.keyCode >= 97 && event.keyCode <= 122) ||
            event.keyCode === 32
        );
    });

    $(document).on("input", ".currency-input", function () {
        formatCurrency(this);
    });
});

function startLoadings(thi, text = "Please Wait...") {
    thi.setAttribute("disabled", true);
    var loader = document.createElement("span");
    $(loader).attr({
        class: "spinner-border spinner-border-sm",
        role: "status",
        "aria-hidden": "true",
    });
    thi.innerHTML = $(loader)[0].outerHTML + "  " + text;
}

function stopLoadings(thi, text, disabled = false) {
    form && $("select,input,textarea").removeAttr("disabled");
    thi.disabled = disabled;
    thi.innerHTML = text;
}

function delay(sec) {
    return new Promise((resolve) => setTimeout(resolve, sec));
}

// HTML entity encoding function
function htmlEncode(text) {
    // Define the regular expressions for HTML entity encoding
    var ampRegex = /&/g;
    var gtRegex = />/g;
    var ltRegex = /</g;

    // Perform HTML entity encoding
    return String(text)
        .replace(ampRegex, "&amp;")
        .replace(gtRegex, "&gt;")
        .replace(ltRegex, "&lt;");
}

function htmlRemove(text) {
    // Define the regular expressions for HTML entity decoding
    var ampRegex = /&amp;/g;
    var gtRegex = /&gt;/g;
    var ltRegex = /&lt;/g;

    // Perform HTML entity decoding
    return String(text)
        .replace(ampRegex, "")
        .replace(gtRegex, "")
        .replace(ltRegex, "");
}

function htmlDecode(text) {
    // Define the regular expressions for HTML entity decoding
    var ampRegex = /&amp;/g;
    var gtRegex = /&gt;/g;
    var ltRegex = /&lt;/g;
    var quot = /&quot;/g;
    // Perform HTML entity decoding
    return String(text)
        .replace(ampRegex, "&")
        .replace(gtRegex, ">")
        .replace(ltRegex, "<")
        .replace(quot, '"');
}

function removeHtmlTags(text) {
    // Define the regular expression for HTML tags
    var htmlRegex = /<[^>]*>/g;

    // Remove HTML tags from the string
    return text.replace(htmlRegex, "");
}

function convertDateInDays(date) {
    var dateString = date;

    // Create a Date object from the given date string
    var givenDate = new Date(dateString);

    // Get the current date
    var currentDate = new Date();

    // Calculate the difference in milliseconds between the two dates
    var differenceInMilliseconds = currentDate - givenDate;

    // Convert the difference to days
    var differenceInDays = Math.floor(
        differenceInMilliseconds / (1000 * 60 * 60 * 24)
    );

    return differenceInDays;
}

function capitalizeFirstLetter(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

async function confirmation(res) {
    const result = await Swal.fire({
        title: res.redirectMessage,
        text: res.redirectConfirmation,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Proceed!",
        allowOutsideClick: false,
    });

    if (result.isConfirmed) {
        if (res?.redirectYesUrl) {
            toastr.success("Redirecting...");
            setTimeout(() => {
                window.location = res.redirectYesUrl;
            }, 1000);
        }
        return true;
    } else {
        if (res?.redirectNoUrl) {
            window.location = res.redirectNoUrl;
        }
        return false;
    }
}

function convertStringToOriginalType(input) {
    // Check if input is a string
    if (typeof input === "string" || input instanceof String) {
        try {
            // Attempt to parse the string
            const parsed = JSON.parse(input);

            return parsed;
        } catch (e) {
            // If parsing fails, it's a regular string
            return input;
        }
    }

    // If it's not a string, return undefined or handle accordingly
    return input;
}

function mb_strimwidth(str, start, width, trimmarker = "...") {
    let result = "";
    let len = 0;

    for (let i = start; i < str.length; i++) {
        let char = str.charAt(i);
        let charCode = char.charCodeAt(0);

        // Increase the length count based on character type
        if (charCode >= 0 && charCode <= 127) {
            len += 1; // ASCII characters
        } else {
            len += 2; // Multibyte characters
        }

        // Break if the desired width is reached
        if (len > width) {
            result += trimmarker;
            break;
        }

        result += char;
    }

    return result;
}

function formatCurrency(ele) {
    //alert(232)

    let value = ele.value.replaceAll(",", "").replaceAll("₹ ", "");
    let newValue = "₹ " + (+value).toLocaleString("en-IN");
    console.log(newValue);
    ele.value = newValue;
}

function formatINR(value) {
    let cleanValue = value.toString().replace(/[^0-9.]/g, ""); // remove commas, ₹, etc.
    let number = parseFloat(cleanValue);

    if (isNaN(number)) return "";

    return (
        "₹ " +
        number.toLocaleString("en-IN", {
            maximumFractionDigits: 2,
            minimumFractionDigits: 0,
        })
    );
}

async function deleteConfirmation(ele, event) {
    event.preventDefault();

    const id = ele.getAttribute("data-id");
    const baseHref = ele.getAttribute("data-href");
    const href = baseHref.replace(":id", id); // Inject ID into URL

    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete this?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        allowOutsideClick: false,
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const formData = new FormData();
                formData.append("_method", "DELETE"); // Laravel expects DELETE via POST + _method
                formData.append("_token", csrfToken); // Add CSRF token

                const res = await makeHttpRequest(href, "POST", formData);

                if (res.success) {
                    Swal.fire("Deleted!", res.success, "success");
                    if (res.tableReload) {
                        table?.ajax?.reload();
                    }
                } else {
                    Swal.fire(
                        "Error!",
                        res.error || "Something went wrong",
                        "error"
                    );
                }
            } catch (error) {
                toastr.error(error.message || "Unexpected error");
            }
        }
    });
}

async function confirmationAndPost(event, data) {
    event.preventDefault();
    Swal.fire({
        title: data.title ?? "Are you sure?",
        text: data.text ?? "You won to retrive this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Proceed!",
        allowOutsideClick: false,
    }).then(async (result) => {
        if (result.isConfirmed) {
            toggleLoader();
            try {
                const res = await makeHttpRequest(
                    data.href,
                    data?.method ?? "POST",
                    data?.postData ?? []
                );
                toggleLoader();
                if (res.status) {
                    res?.data?.sweetAlert &&
                        Swal.fire({
                            title: "Deleted!",
                            text: res.message,
                            icon: "success",
                        });

                    !res?.data?.sweetAlert && toastr.success(res.message);

                    res?.data?.redirectUrl &&
                        toastr.success("Redirecting...") &&
                        setTimeout(() => {
                            window.location = res?.data?.redirectUrl;
                        }, 1500);

                    res?.data?.reload && window.loaction.reload();

                    res?.data?.confirmation &&
                        (await confirmation(res.data.confirmation));

                    res.data.tableReload && table.ajax && table.ajax.reload();
                } else if (!res.success) {
                    Swal.fire({
                        title: "Error!!",
                        text: res.message,
                        icon: "error",
                    });
                } else {
                    Swal.fire({
                        title: "Error!!",
                        text: "Something Went wrong!!",
                        icon: "error",
                    });
                }
            } catch (error) {
                toggleLoader();
                toastr.error(error);
            }
        }
    });
}

const toastr = {
    success: (message) => {
        showSuccessToast("Success!", message);
    },
    error: (message) => {
        showDangerToast("Error!", message);
    },
};

const validationConfig = {
    errorPlacement: function (error, element) {
        if (element.closest(".input-group")?.length) {
            error.insertAfter(element.closest(".input-group"));
        } else {
            if (
                $(element).hasClass("after-parent") ||
                $(element).closest(".after-parent")
            ) {
                let parent;
                if ($(element).closest(".after-parent")) {
                    parent = $(element).closest(".after-parent")[0];
                } else {
                    parent = $(element).parent()[0];
                }
                error.addClass("text-center w-100").insertAfter(parent);
            } else {
                error.insertAfter(element);
            }
        }
    },
};
