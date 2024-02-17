jQuery(document).ready(function($) {
    // Cache frequently used elements
    var userDetailsContainer = $('#user-details');

    // Function to fetch user details
    function fetchUserDetails(userId) {
        return $.ajax({
            url: 'https://jsonplaceholder.typicode.com/users/' + userId,
            method: 'GET',
            dataType: 'json'
        });
    }

    // Event delegation for handling clicks on user links
    $(document).on('click', 'table a.user-link', function(e) {
        e.preventDefault();
        var userId = $(this).data('user-id');
        fetchUserDetails(userId)
            .done(displayUserDetails)
            .fail(function(_, error) { // Omitting unused parameters
                console.error('Error fetching user details:', error);
                userDetailsContainer.html('<p class="error">Failed to fetch user details.</p>');
            });
    });

    // Function to display user details
    function displayUserDetails(user) {
        var userDetailsHtml = `<h2>User Details</h2>
                               <ul>
                                   <li><strong>Name:</strong> ${user.name}</li>
                                   <li><strong>Username:</strong> ${user.username}</li>
                                   <li><strong>Email:</strong> ${user.email}</li>
                                   <li><strong>Phone:</strong> ${user.phone}</li>
                                   <li><strong>Website:</strong> ${user.website}</li>
                               </ul>`;
        userDetailsContainer.html(userDetailsHtml);
    }
});
