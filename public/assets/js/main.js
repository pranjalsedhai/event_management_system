document.addEventListener("DOMContentLoaded", function () {
  // email validation on registration
  const emailInput = document.getElementById("email");
  const emailError = document.getElementById("email-error");

  if (emailInput) {
    emailInput.addEventListener("blur", function () {
      const email = this.value.trim();

      if (email.length > 0) {
        // returns promise
        fetch("/check_email.php?email=" + encodeURIComponent(email))
          .then((response) => response.json())
          .then((data) => {
            if (data.exists) {
              emailError.textContent = "Email already registered";
              emailError.style.display = "block";
            } else {
              emailError.style.display = "none";
            }
          });
      }
    });
  }

  // ajax autocomplete search
  const searchInput = document.getElementById("search-input");
  const searchResults = document.getElementById("search-results");
  const searchButton = document.getElementById("search-button");

  // checks if the search bar exist
  if (searchInput) {
    // wait for a short time before making ajax call
    let timeout = null;

    // runs everytime when a user types something on searchbar
    searchInput.addEventListener("input", function () {
      const query = this.value.trim();
      // cancels previous ajax call and only the last one after pause triggers
      clearTimeout(timeout);

      // does not work if query is too short
      if (query.length < 2) {
        searchResults.innerHTML = "";
        searchResults.style.display = "none";
        return;
      }

      // waits 300ms after user types, before showing drop down
      timeout = setTimeout(() => {
        fetch("/ajax_search.php?q=" + encodeURIComponent(query))
          .then((response) => response.json())
          .then((data) => {
            if (data.length > 0) {
              let html = "<ul>";
              data.forEach((event) => {
                html += `<li><a href="/event.php?id=${event.id}">${event.title} - ${event.date}</a></li>`;
              });
              html += "</ul>";
              searchResults.innerHTML = html;
              searchResults.style.display = "block";
            } else {
              searchResults.innerHTML =
                '<p style="padding: 10px;">No results found</p>';
              searchResults.style.display = "block";
            }
          });
      }, 300);
    });

    //searches when search button is clicked
    if (searchButton) {
      searchButton.addEventListener("click", function () {
        const query = searchInput.value.trim();
        if (query.length > 0) {
          window.location.href = "/search.php?q=" + encodeURIComponent(query);
        }
      });

      // works when pressed enter
      searchInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
          searchButton.click();
        }
      });
    }
  }
});
