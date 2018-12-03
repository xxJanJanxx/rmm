<?= $this->Html->css(['bootstrap', 'custom.min', 'font-awesome.min']) ?>
<style>
body {
  background-image: url('img/wallpaper.jpg');
  background-size: cover;
  color: white;
}

.well {
  padding:20px;
  background-color:rgba(0, 0, 0, 0.38);
}

.loginDiv {
  padding-top:8%
}
</style>
<body>
    <div class="row">
      <div class="col-md-4 col-md-offset-4 loginDiv">
        <div class="well">
          <section class="text-center">
              <h1>RMM Meatshop</h1>
              <div>

                <?= $this->Flash->render() ?>
              	<?= $this->Form->create()	?>

                <?= $this->Form->input('username', ['class' => 'form-control', 'required' => true])	?>

              </div>
              <div>

                <?=	$this->Form->input('password',['class' => 'form-control', 'required' => true, 'type' => 'password'])	?>

              </div>
              <div><br>

                <?=	$this->Form->button('Log in',['class' => 'form-control btn btn-success', 'required' => true])	?>

                <?=	$this->Form->end()	?>

                <?= $this->Html->link('Forgot Password', ['action' => 'forgot'], ['style' => 'color:white;font-size:20px;']); ?>

              </div>

              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
