(function() {
  const edits = document.querySelectorAll('button.edit');

  edits.forEach(item => {
    item.addEventListener('click',edit)
  })
})();

function edit(e) {

  const cat = this.parentNode.children[0].innerHTML;
  const input = document.createElement('input');
  input.type = "text";
  input.id="catInput";
  input.value = cat;
  this.parentNode.children[0].innerHTML = '';
  this.parentNode.children[0].appendChild(input);
  const saveBtn = document.createElement('button');
  saveBtn.classList = "save btn btn-success";
  saveBtn.innerHTML = "Save";
  saveBtn.addEventListener('click', save);
  this.parentNode.appendChild(saveBtn);
  this.removeEventListener('click', edit);
}

function save(e) {
  const cat = this.parentNode.children[0].children[0].value;
  this.parentNode.children[0].innerHTML = cat;
  this.parentNode.children[1].addEventListener('click', edit);
  this.parentNode.removeChild(this);
}
