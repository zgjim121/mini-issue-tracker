document.addEventListener('DOMContentLoaded', function() {
    const commentForm = document.getElementById('comment-form');
    const commentsContainer = document.getElementById('comments-container');
    const loadMoreButton = document.getElementById('load-more-comments');
    const authorNameInput = document.getElementById('author_name');
    const bodyInput = document.getElementById('body');
    const authorNameError = document.getElementById('author_name_error');
    const bodyError = document.getElementById('body_error');

    if (!commentForm || !window.currentIssueId) return;

    // Handle comment submission
    commentForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Clear previous errors
        clearErrors();

        const formData = new FormData(commentForm);

        fetch(`/issues/${window.currentIssueId}/comments`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Prepend the new comment
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data.html;
                const newComment = tempDiv.firstElementChild;
                
                commentsContainer.insertBefore(newComment, commentsContainer.firstChild);

                // Clear the form
                commentForm.reset();
            } else if (data.errors) {
                // Show validation errors
                showErrors(data.errors);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Handle load more comments
    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function() {
            const page = this.getAttribute('data-page');
            
            fetch(`/issues/${window.currentIssueId}/comments?page=${page}`, {
                headers: {
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Append the new comments
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = data.html;
                    
                    while (tempDiv.firstChild) {
                        commentsContainer.appendChild(tempDiv.firstChild);
                    }

                    // Update the page number or hide button
                    if (data.pagination.has_more) {
                        loadMoreButton.setAttribute('data-page', data.pagination.current_page + 1);
                    } else {
                        loadMoreButton.style.display = 'none';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }

    function clearErrors() {
        authorNameError.classList.add('hidden');
        bodyError.classList.add('hidden');
        authorNameError.textContent = '';
        bodyError.textContent = '';
    }

    function showErrors(errors) {
        if (errors.author_name) {
            authorNameError.textContent = errors.author_name[0];
            authorNameError.classList.remove('hidden');
        }
        if (errors.body) {
            bodyError.textContent = errors.body[0];
            bodyError.classList.remove('hidden');
        }
    }
});