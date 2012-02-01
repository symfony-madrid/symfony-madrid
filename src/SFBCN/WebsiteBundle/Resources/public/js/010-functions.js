Namespace = {};


(function(NS, window){

    var notBlankConstraint = function(input) {
        return ( typeof input !== "undefined" && input.trim() !== "" );
    };

    var emailConstraint = function(input) {
        var emailPattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        return ( notBlankConstraint(input) && emailPattern.test(input) );
    };

    NS.ValidatorConstraints = {
        "validateMandatory" : notBlankConstraint,
        "validateEmail"     : emailConstraint
    };

})(Namespace, window);


function resetForm(contactForm)
{
    $(contactForm).find("label").each(function(index, htmlTag){
        $(htmlTag).removeClass("form-error");
    });
}

/**
 * Check for form is successful or not before send data to server.
 *
 * @param {DOMObject} contactForm Form with data.
 */
function validateForm(contactForm) {

    var formIsValid = true;
    var inputIsValid = false;

    $(contactForm).find(".form-validate").each(function(index, input){
        if ( $(input).hasClass("validate-mandatory") ) {
            inputIsValid = Namespace.ValidatorConstraints.validateMandatory($(input).val());
            formIsValid &= inputIsValid;
            if (!inputIsValid) {
                $(input).parent().find("label").addClass("form-error");
            }
        }
        if ( $(input).hasClass("validate-email") ) {
            inputIsValid = Namespace.ValidatorConstraints.validateEmail($(input).val());
            formIsValid &= inputIsValid;
            if (!inputIsValid) {
                $(input).parent().find("label").addClass("form-error");
            }
        }
    });

    return ( formIsValid && $(contactForm).find("textarea").val() );
}


/**
 * Action to execute when server is OK.
 *
 * @param {Object} data Response receive from server.
 */
function _onSuccess(data) {
    alert(data.message);
    return true;
}


/**
 * Action to execute when an error is produced.
 *
 * @param {Object} xhr Ajax response receive from server.
 */
function _onError(xhr) {
    alert($.parseJSON(xhr.responseText).error.message);
    return true;
}


/**
 * Send the form serialized to the server.
 *
 * @param {DOMObject} contactForm Form with data.
 */
function sendForm(contactForm) {
    $.ajax({
        url         : $(contactForm).attr('action'),
        data        : $(contactForm).serialize(),
        dataType    : 'json',
        type        : 'POST',
        success     : _onSuccess,
        error       : _onError, 
    });
}


/**
 * Attach submit event to Contact Form.
 *
 * @param {DOMObject} contactForm Is the Dom object to attach the event.
 */
function attachEventToContactForm(contactForm) {
    
    $(contactForm).submit(function(e) {

        e.preventDefault();
        resetForm(contactForm);

        if (validateForm(contactForm))
        {
            sendForm(e.target);   
        }
        else
        {
            alert("ERROR");
        }

    });
}


/**
 * This will be executed after render full page.
 */
$(document).ready(function() {

    /**
     * This way is a trick, we would should make a module for each 
     * page instead of check for each page if any thing is available.
     *
     * But, this is only the first version, step-by-step!!
     */
    var contactForm = $('#contact');

    if (0 !== contactForm.length)
    {
        attachEventToContactForm( contactForm[0] );
    }

});