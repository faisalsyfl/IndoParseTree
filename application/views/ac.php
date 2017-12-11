    <div id="hasil" class="row" style="">
      <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><span class="glyphicon glyphicon-check aria-hidden="true"></span>&nbsp;&nbsp;Calculate Result</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-info">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i>Ambiguity </i>Checker</h3>
                    </div>
                    <div class="panel-body">
                      <table class="table table-condensed">
                        <thead>
                          <tr>
                            <td>No.</td>
                            <td>Word</td>
                            <td>Count</td>
                            <td>Prob</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(isset($ac)){ $no=1;foreach($ac as $i){?>
                            <tr>
                              <td><?php echo $no++; ?></td>
                              <td><?php echo $i['key']; ?></td>
                              <td><?php echo $i['count']; ?></td>
                              <td><?php echo $i['prob']; ?></td>
                            </tr>
                          <?php  }}?>
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>            
            </div>                        
          </div>
        </div>
      </div>
    </div>    