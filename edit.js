(function() {
  const edits = document.querySelectorAll('button.edit');
  const dels = document.querySelectorAll('button.del');

  edits.forEach(item => {
    item.addEventListener('click',edit)
  })
  dels.forEach(item => {
    item.addEventListener('click',del)
  })
  const add = document.querySelector('#add');
  const list = document.querySelector('.edit__list');
  add.addEventListener('click', function (e)  {
    const item = document.createElement('li');
    item.classList = "edit__item";
    const span = document.createElement('span');
    span.classList = "edit__cat";
    const input = document.createElement('input');
    input.required = true;
    span.appendChild(input);
    const buttons = document.createElement('div');
    buttons.classList = "edit__itemBtn"
    const editBtn = document.createElement('button');
    editBtn.classList = "edit btn btn-primary";
    editBtn.addEventListener('click', edit);
    editBtn.innerHTML = "Edit"
    const saveBtn = document.createElement('button');
    saveBtn.classList = "save btn btn-success";
    saveBtn.innerHTML = "Save";
    saveBtn.addEventListener('click', save);
    buttons.appendChild(editBtn);
    buttons.appendChild(saveBtn);
    item.appendChild(span);
    item.appendChild(buttons);
    list.appendChild(item);
  })
})();

function edit(e) {

  const cat = this.parentNode.parentNode.children[0].innerHTML;
  this.parentNode.parentNode.children[0].dataset.edit = cat;
  const input = document.createElement('input');
  input.type = "text";
  input.id="catInput";
  input.value = cat;
  this.parentNode.parentNode.children[0].innerHTML = '';
  this.parentNode.parentNode.children[0].appendChild(input);
  const saveBtn = document.createElement('button');
  saveBtn.classList = "save btn btn-success";
  saveBtn.innerHTML = "Save";
  saveBtn.addEventListener('click', save);
  this.parentNode.appendChild(saveBtn);
  this.removeEventListener('click', edit);
  this.parentNode.children[1].style.display = "none";

}

function save(e) {
  const cat = this.parentNode.parentNode.children[0].children[0].value;
  const old = this.parentNode.parentNode.children[0].dataset.edit
  if(old) {
    window.location.href = "./edit.php?save="+cat+"&edit="+old;
  }
  else {
    window.location.href = "./edit.php?save="+cat;
  }
  this.parentNode.parentNode.children[0].innerHTML = cat;
  this.parentNode.children[0].addEventListener('click', edit);
  this.parentNode.removeChild(this);
  // this.parentNode.children[1].style.display = "block";
}

function del (e) {
  const cat = this.parentNode.parentNode.children[0].innerHTML;
  window.location.href = "./edit.php?delete="+cat;
}
