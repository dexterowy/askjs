(function() {
  const edits = document.querySelectorAll('button.edit');

  edits.forEach(item => {
    item.addEventListener('click',edit)
  })
  const add = document.querySelector('#add');
  const list = document.querySelector('.edit__list');
  add.addEventListener('click', function (e)  {
  const item = document.createElement('li');
  item.classList = "edit__item";
  const span = document.createElement('span');
  span.classList = "edit__cat";
  const input = document.createElement('input');
  span.appendChild(input);
  const editBtn = document.createElement('button');
  editBtn.classList = "edit btn btn-primary";
  editBtn.addEventListener('click', edit);
  editBtn.innerHTML = "Edit"
  const delBtn = document.createElement('button');
  delBtn.classList = "del btn btn-danger";
  delBtn.innerHTML = "Delete with all posts";
  const saveBtn = document.createElement('button');
  saveBtn.classList = "save btn btn-success";
  saveBtn.innerHTML = "Save";
  saveBtn.addEventListener('click', save);
  this.parentNode.appendChild(saveBtn);
  item.appendChild(span);
  item.appendChild(editBtn);
  item.appendChild(delBtn);
  item.appendChild(saveBtn);
  list.appendChild(item);
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
