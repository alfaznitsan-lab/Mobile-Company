function fetchFilteredResults(event, pageNumber) {
    if (event) {
        event.preventDefault(); 
    }

    var resultsContainer = document.getElementById('mobile-list-container');
    var errorContainer = document.getElementById('filtererror');
    var baseAjaxUrl = resultsContainer.getAttribute('data-base-ajax-url');

    if (errorContainer) {
        errorContainer.innerHTML = '';
        errorContainer.style.display = 'none'; 
    }

    if (!baseAjaxUrl) {
        console.error("AJAX base URL template missing!");
        if (errorContainer) {
            errorContainer.innerHTML = '<p>Configuration error: Missing AJAX URL.</p>';
            errorContainer.style.display = 'block';
        }
        return;
    }
    
    var filterName = document.getElementById('filterName').value || '';
    var filterBrand = document.getElementById('filterBrand').value || '';
    var filterPrize = document.getElementById('filterPrize').value || '';

    var url = new URL(baseAjaxUrl);
    var postBody = new URLSearchParams({
        'tx_mobilecompany_mobilecompanylistplugin[filterName]': filterName,
        'tx_mobilecompany_mobilecompanylistplugin[filterBrand]': filterBrand,
        'tx_mobilecompany_mobilecompanylistplugin[filterPrize]': filterPrize,
        'tx_mobilecompany_mobilecompanylistplugin[currentPageNumber]': pageNumber
    });

    // Fetch the data
    fetch(url.toString(), {
        method: 'POST',
        body: postBody
    })
    .then(response => {
        console.log(response);
        if (!response.ok) {
            throw new Error(response.status + ' ' + response.statusText);
        }
        return response.text();
    })
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        const newContainer = doc.getElementById('mobile-list-container');

        if (newContainer) {
            const contentTrimmed = newContainer.innerHTML.trim();
            
            if (contentTrimmed === '' || contentTrimmed.includes('No items found')) {
                resultsContainer.innerHTML = '';
                if (errorContainer) {
                    errorContainer.innerHTML = '<p>No matching data found.</p>';
                    errorContainer.style.display = 'block';
                }
            } else {
                resultsContainer.innerHTML = newContainer.innerHTML;
                if (errorContainer) {
                    errorContainer.innerHTML = '';
                    errorContainer.style.display = 'none';
                }
                console.log("AJAX data loaded successfully.");
            }
        } else {
            console.error("Target container ID missing in AJAX response.");
            if (errorContainer) {
                errorContainer.innerHTML = '<p>Error processing response from server.</p>';
                errorContainer.style.display = 'block';
            }
        }
    })
    .catch(error => {
        console.error("AJAX load failed:", error);
        if (errorContainer) {
            errorContainer.innerHTML = '<p style="color:red;">No matching data found.</p>';
            errorContainer.style.display = 'block';
        }
    });
}