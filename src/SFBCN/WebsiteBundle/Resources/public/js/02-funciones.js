/**
 * Check for form is successful or not before send data to server.
 *
 * @param {DOMObject} contactForm Form with data.
 */
function validateForm(contactForm) {

    var formIsValid = true;

    $(contactForm).find("input[type=text]").each(function(index, input){
        formIsValid &= ( "" !== $(input).val() );
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

        if (validateForm(contactForm))
        {
            sendForm(e.target);   
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