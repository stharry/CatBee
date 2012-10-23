$(document).ready(function () {

    $("#aaa").click(function () {

        var postData = createCatBeeGetFacebookContactsRequest();
        var sharePoint = getCatBeeShareUrl();

        $.ajax({
            type:'POST',
            url:sharePoint,
            dataType: 'json',
            data: postData,

            timeout: 7200,

            error: function(xhr, textStatus, error){

                addContacts(xhr.responseText);
            },

            success:function (data) {

                addContacts(data);
            }

        });
    });
}
);

function addContacts(contactsData)
{
    alert(contactsData);

    var shareNode = $.parseJSON(contactsData);

    var contacts = shareNode.friends;

    var contactsContainer = document.getElementById('ContactsArea');


    if ($('#contactsRemovableFrame').length > 0) {
        var contactsRemovableFrame = document.getElementById('contactsRemovableFrame');
        contactsContainer.removeChild(contactsRemovableFrame);
    }

    var contactsRemovableFrame = document.createElement('div');
    contactsRemovableFrame.setAttribute('id', 'contactsRemovableFrame');
    contactsContainer.appendChild(contactsRemovableFrame);


    for (var x = 0; x < contacts.length; x++) {

        var oneContactFrame = document.createElement('div');
        contactsRemovableFrame.appendChild(oneContactFrame);

        var contactImage = document.createElement('img');
        contactImage.setAttribute('src', contacts[x].sharedPhoto);
        oneContactFrame.appendChild(contactImage);

        var contactLabel = document.createElement('label');
        contactLabel.innerHTML = contacts[x].firstName;
        contactLabel.setAttribute('for', 'contactCheckNo' + x);
        oneContactFrame.appendChild(contactLabel);

        var contactCheckbox = document.createElement('input');
        contactCheckbox.type = "checkbox";
        contactCheckbox.setAttribute('id', 'contactCheckNo' + x);
        oneContactFrame.appendChild(contactCheckbox);
    }

}

function getCatBeeShareUrl()
{
    return "http://127.0.0.1:8080/CatBee/api/share/";
}

function createCatBeeGetFacebookContactsRequest() {

    return {
        action:'getcontacts',
        context:{

            leader:{
                email:"vadim.chebyshev@retalix.com"
            },
            context:
            {
                type: "facebook"

            }
        }
    };
}

