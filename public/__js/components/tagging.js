class Tagging {
	constructor() {
		this.tagChipsWidth = 0;
		this.tagList = [];
		this.padding = 18;
		this.runningNumber = 0;
		this.placeholder = 'แท๊ก';
		this.dataName = 'Tagging';
		this.panel = '_tags';
		this.code = null;
	}

	load(tagJson){

		this.init();
		this.bind();
		this.crateTagList();
		this.crateInputTagField();

		if (typeof tagJson != 'undefined') {
			let _tags = JSON.parse(tagJson);
			for (let i = 0; i < _tags.length; i++) {
				this.createTagChip(_tags[i]['name']);
			}
		}

	}

	init(){
		this.tagChipsWidth = 0;
		this.code = this.generateCode();
	}

	bind(){}

	createHiddenField(index,id,tagName) {
		let input = document.createElement('input');
	  input.setAttribute('type','hidden');
	  input.setAttribute('name',this.dataName+'['+index+']');
	  input.setAttribute('id',id+'_name');
	  input.setAttribute('value',tagName);
	  $('form').append(input);
	}

	removeHiddenField(id) {
		$('#'+id+'_name').remove();
	}

	crateTagList(){
		let span = document.createElement('span');
		span.setAttribute('id',this.code+'_tag_list');
		
		document.getElementById(this.panel).appendChild(span);
	}

	crateInputTagField(){

		let _this = this;

		let input = document.createElement('input');
		input.setAttribute('type','search');
		input.setAttribute('id',this.code+'_tag_input');
		input.setAttribute('tabindex','0');
		input.setAttribute('autocomplete','off');
		input.setAttribute('autocorrect','off');
		input.setAttribute('autocapitalize','off');
		input.setAttribute('spellcheck','false');
		input.setAttribute('role','textbox');
		input.setAttribute('placeholder',this.placeholder);
		input.style.width = $('#'+this.panel).width()+'px';

		input.addEventListener("keydown", function(e){

			if(e.keyCode == 13){
				e.preventDefault();

				if(this.value != ''){
					_this.createTagChip(this.value);
					this.value = '';
				}
			
			}else if(e.keyCode == 8){

				if(this.value == ''){
					e.preventDefault();

					let obj = document.getElementById(_this.tagList[_this.tagList.length-1]);

					if(obj != null){

						document.getElementById(_this.code+'_tag_input').value = $(obj).find('span.tag-name').text();
						document.getElementById(_this.code+'_tag_input').select();

						_this.tagChipsWidth -= $(obj).width()+_this.padding; 
						_this.calInputFielsWidth();

						_this.removeHiddenField(_this.tagList[_this.tagList.length-1]);

						// remove tag chip
						$(obj).remove();

						// remove from array
						_this.tagList.splice(_this.tagList.length-1,1);
					}

				}

			}

		}, false);

		$(input).on('blur',function(){
			if(this.value != ''){
				_this.createTagChip(this.value);
				this.value = '';
			}
		});

		document.getElementById(this.panel).appendChild(input);
	}

	createTagChip(tagName){

		let _this = this;

		let id = 'tag_'+this.code+'_'+this.runningNumber;
		this.tagList.push(id);

		let tagChip = document.createElement('span');
		tagChip.setAttribute('class','tag-chip');
		tagChip.setAttribute('id',id);

		let tagNameElem = document.createElement('span');
		tagNameElem.setAttribute('class','tag-name');
		tagNameElem.innerHTML = tagName;

		let tagDelete = document.createElement('span');
		tagDelete.setAttribute('class','tag-delete-chip');
		tagDelete.innerHTML = '×';

		tagDelete.addEventListener("click", function(e){

			_this.tagList.splice(_this.tagList.indexOf($(this).parent().attr('id')),1);

			_this.tagChipsWidth -= $(this).parent().width()+_this.padding; 
			_this.calInputFielsWidth();

			$('#'+this.code+'_tag_input').focus();

			_this.removeHiddenField($(this).parent().attr('id'));

			// remove tag chip
			$(this).parent().remove();

		}, false);

		tagChip.appendChild(tagNameElem);
		tagChip.appendChild(tagDelete);
		tagChip.style.display = 'none';
		document.getElementById(this.code+'_tag_list').appendChild(tagChip);
		
		this.createHiddenField(this.runningNumber++,id,tagName);

		this.tagChipsWidth += $(tagChip).width()+this.padding; 
		this.calInputFielsWidth();
		tagChip.style.display = 'inline-block';
		
	}


	generateCode() {

		let codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	  codeAlphabet += "abcdefghijklmnopqrstuvwxyz";
	  codeAlphabet += "0123456789";

	  let code = '';
	  let len = codeAlphabet.length;

	  for (let i = 0; i <= 7; i++) {
	  	code += codeAlphabet[Math.floor(Math.random() * (len - 0) + 0)];
	  };

		return code;
	}

	calInputFielsWidth(){
		let inputFieldWidth = $('#'+this.panel).width() - (this.tagChipsWidth % $('#'+this.panel).width());

		// if(this.tagChipsWidth > $('#'+this.panel).width()) {}

		if(inputFieldWidth > 100){
			document.getElementById(this.code+'_tag_input').style.width = inputFieldWidth+'px';
		}else{
			this.tagChipsWidth += inputFieldWidth;
			document.getElementById(this.code+'_tag_input').style.width = $('#'+this.panel).width()+'px';
		}
	}

	setPlaceHolder(placeholder){
		this.placeholder = placeholder; 
	}

	setDataName(dataName) {
		this.dataName = dataName;
	}

	setPanel(panel) {
		this.panel = panel;
	}
}
