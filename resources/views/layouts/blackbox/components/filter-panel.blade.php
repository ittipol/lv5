<div class="clearfix">
  <label class="filter-icon pull-right" for="filter_panel_trigger">
    <img src="/images/icons/sort.png">
    <input type="checkbox" id="filter_panel_trigger" class="filter-panel-trigger" />
  </label>
</div>

<script type="text/javascript">

class Filter {
  constructor() {
    this.filterPanelOriginalTop;
    this.filterPanelOriginalHeight;
    this.filterPanelExtendHeight;
  }

  load() {
    this.bind();
    this.setLayout();
  }

  bind() {

    let _this = this;

    $(window).resize(function() {

      let w = window.innerWidth;
      let h = window.innerHeight;

      $('.filter-panel').css({
        height: h - 60
      });

      if(w > 992) {

        if($('#filter_panel_trigger').is(':checked')) {
          $('#filter_panel_trigger').trigger('click');
        }

        $('.filter-panel').css({
          height: h - $('.filter-panel').offset().top
        });
      }

    });

    $('.main-panel-overlay').on('click',function(){
      if($('#filter_panel_trigger').is(':checked')) {
        $('#filter_panel_trigger').trigger('click');
      }
    });

    $('#filter_panel_trigger').on('click',function(){
      if($(this).is(':checked')) {
        $('.filter-panel').addClass('is-filter-panel-open');
        $('.main-panel-overlay').addClass('isvisible');
      }else{
        $('.filter-panel').removeClass('is-filter-panel-open');
        $('.main-panel-overlay').removeClass('isvisible');
      }
    }); 

    $(".nano").on("update", function(event, vals){ 
       // console.log("pos=" + vals.position + ", direction=" + vals.direction + "\n" )

       if(vals.position > _this.filterPanelOriginalTop) {
        $('.filter-panel').css({
          top: vals.position,
          height: _this.filterPanelExtendHeight
        });
       }else{
        $('.filter-panel').css({
          top: _this.filterPanelOriginalTop,
          height: _this.filterPanelOriginalHeight
        });
       }

    });

    // $(".nano").bind("scrolltop", function(e){
    // });

    // $(".nano").bind("scrollend", function(e){
    // });

    $('.filter-panel .sorting-option-radio').on('click',function(){
      if($(this).is(':checked')) {
        $('#sorting_form').submit();
      }
    });
  }

  setLayout() {
    
    let w = window.innerWidth;
    let h = window.innerHeight;

    this.filterPanelOriginalTop = $('.filter-panel').position().top;
    this.filterPanelOriginalHeight = h - $('.filter-panel').offset().top;
    this.filterPanelExtendHeight = this.filterPanelOriginalHeight + this.filterPanelOriginalTop;

    $('.filter-panel').css({
      height: this.filterPanelOriginalHeight
    });

  }

}

$(document).ready(function(){
  const filter = new Filter;
  filter.load();
});

</script>

<div class="filter-panel nano">
  <div class="nano-content">
    <div class="filter-panel-inner">
      <?php
        echo Form::open(['method' => 'get','id' => 'sorting_form']);
      ?>
      <?php
        echo Form::hidden('q', 'company');
      ?>
      <?php foreach ($sortingOptions as $value): ?>
        <?php if(!empty($value['options'])): ?>
          <h5><?php echo $value['title']; ?></h5>
          <div class="line"></div>
          <ul class="nav-stack-item ">
            <?php foreach ($value['options'] as $option): ?>

              <?php $checked = false; ?>
              <?php if(!empty($option['checked']) && $option['checked']): ?>
                <?php $checked = true; ?>
              <?php endif; ?>

              <li class="item">
                <label <?php if($checked) echo 'class="checked"'; ?> for="<?php echo $option['id']; ?>">
                  <span><?php echo $option['name']; ?></span>
                  <input type="<?php echo $value['type']; ?>" id="<?php echo $option['id']; ?>" <?php if($checked) echo 'checked'; ?> class="sorting-option-radio" value="<?php echo $option['value']; ?>" name="sort" />
                </label>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      <?php endforeach; ?>
      <?php
        echo Form::close();
      ?>
    </div>
  </div>
</div>
