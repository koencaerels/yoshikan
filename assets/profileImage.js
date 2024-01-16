import './styles/profileImage.css';

document.addEventListener('DOMContentLoaded', function () {

  var form = document.getElementById('uploadForm');
  var loadingDiv = document.getElementById('loadingDiv');
  var submitButton = document.getElementById('submitButton');

  form.addEventListener('submit', function () {
    loadingDiv.style.display = 'block';
    submitButton.style.display = 'none';
  });

});
