document.addEventListener('DOMContentLoaded', function() {
    const tagForm = document.getElementById('tag-form');
    const currentTagsContainer = document.getElementById('current-tags');
    const tagSelect = document.getElementById('tag_id');
    const tagError = document.getElementById('tag_error');

    if (!tagForm || !window.currentIssueId) return;


    tagForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const tagId = tagSelect.value;
        if (!tagId) return;


        tagError.classList.add('hidden');
        tagError.textContent = '';

        fetch(`/issues/${window.currentIssueId}/tags`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                tag_id: tagId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {

                const tagChip = document.createElement('span');
                tagChip.className = 'tag-chip';
                if (data.tag.color) {
                    tagChip.style.backgroundColor = data.tag.color;
                    tagChip.style.color = 'white';
                }
                tagChip.innerHTML = `
                    ${data.tag.name}
                    <button type="button" class="ml-1 text-xs hover:text-red-600 remove-tag" data-tag-id="${data.tag.id}">
                        ×
                    </button>
                `;
                
                currentTagsContainer.appendChild(tagChip);


                const option = tagSelect.querySelector(`option[value="${tagId}"]`);
                if (option) option.remove();


                tagSelect.value = '';


                const noTagsMessage = currentTagsContainer.querySelector('.text-gray-500');
                if (noTagsMessage) noTagsMessage.remove();
            } else {
                tagError.textContent = data.message;
                tagError.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            tagError.textContent = 'An error occurred while attaching the tag.';
            tagError.classList.remove('hidden');
        });
    });


    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-tag')) {
            const tagId = e.target.getAttribute('data-tag-id');
            const tagChip = e.target.closest('.tag-chip');
            const tagName = tagChip.textContent.trim().replace('×', '').trim();

            fetch(`/issues/${window.currentIssueId}/tags/${tagId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {

                    tagChip.remove();


                    const option = document.createElement('option');
                    option.value = tagId;
                    option.textContent = tagName;
                    tagSelect.appendChild(option);


                    const remainingTags = currentTagsContainer.querySelectorAll('.tag-chip');
                    if (remainingTags.length === 0) {
                        const noTagsMessage = document.createElement('p');
                        noTagsMessage.className = 'text-gray-500 text-sm';
                        noTagsMessage.textContent = 'No tags attached.';
                        currentTagsContainer.appendChild(noTagsMessage);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
});