@extends('layouts.blackbox.main')
@section('content')
  <div class="entity-content">

    <div class="entity-header" style="background-image: url('/images/store.jpg');">
        <div class="contain-fluid">
          <div class="entity-header-overlay">
            <div class="row">
              <div class="col-md-12 col-lg-9">
                <div class="entity-header-info clearfix">
                  <div class="entity-logo" style="background-image: url('<?php echo $logo ?>');"></div>
                  <section class="entity-description">
                    <h2><?php echo strip_tags($name); ?></h2>
                    <p><?php echo strip_tags($short_description); ?></p>
                  </section>
                </div>
              </div>
              <div class="col-md-12 col-lg-3">
                <div class="entity-header-action">

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
@stop