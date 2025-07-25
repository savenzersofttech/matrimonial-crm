/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */

"use strict";

// Load subcategories when category changes
      function loadSubcategories(categoryId, selectedSubcatId = null) {
          if(categoryId){
              $('#subCategoryId').html('<option value="">Loading...</option>');
              $.ajax({
                  url: '/dashboard/get-subcategories/' + categoryId,
                  type: "GET",
                  success: function(data){
                      if (!data.length) {
                          $('#subCategoryId').html('<option value="">No Sub Category</option>');
                      } else {
                          let options = '<option value="">Select Sub Category</option>';
                          data.forEach(function(subcategory){
                              let selected = selectedSubcatId == subcategory.id ? 'selected' : '';
                              options += `<option value="${subcategory.id}" ${selected}>${subcategory.title}</option>`;
                          });
                          $('#subCategoryId').html(options);
                      }
                      $('#subCategoryId').trigger('change.select2'); // refresh select2
                  },
                  error: function(){
                      $('#subCategoryId').html('<option value="">Error loading subcategories</option>');
                  }
              });
          } else {
              $('#subCategoryId').html('<option value="">Select Sub Category</option>');
          }
      }




   /**
 * Global async request helper using jQuery
 * @param {string} url - The endpoint URL
 * @param {string} method - GET, POST, etc.
 * @param {object} data - Data to send (optional)
 * @returns {Promise<object>} - Resolves with response data or throws an Error
 */
async function sendRequest(url, method = "GET", data = {}) {
    try {
        const response = await $.ajax({
            url: url,
            type: method,
            data: data,
            dataType: 'json'
        });
        return response; // ✅ Return only parsed data
    } catch (xhr) {
        // ✅ Throw a clean error with optional message
        let errorMessage = "Request failed";
        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
        } else if (xhr.statusText) {
            errorMessage = xhr.statusText;
        }
        throw new Error(errorMessage);
    }
}



     // Toggle entry_coin readonly based on access_type
      function toggleEntryCoin() {
          let val = $('#access_type').val();
          if(val === 'free'){
              $('input[name="entry_coin"]').val(0).prop('readonly', true);
          } else{
              $('input[name="entry_coin"]').prop('readonly', false);
          }
      }


        // Initialize select2
      $('.select2').select2({
          allowClear: true
      });



      
    $('.del-btn').click(function (e) {
        e.preventDefault();
        let form = $(this).closest('form');

        swal({
            title: "Are you sure?",
            text: "Once deleted, this user cannot be recovered!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            } else {
                // swal("Your user is safe!");
            }
        });
    });