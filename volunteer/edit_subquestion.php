<style>
      .save-btn{
        background: #c70039;
        color:white; 
        border:1px solid transparent;
        font-size: 1rem;
        font-family: 'roboto',sans-serif;
    }
    .save-btn:hover{
        background: white;
        border:1px solid #c70039;
        color:#c70039;
    }
      .back-btn{
        background: #8566aa;
        color:white; 
        border:1px solid transparent;
        font-size: 1rem;
        font-family: 'roboto',sans-serif;

    }
    .back-btn:hover{
        background: white;
        border:1px solid #8566aa;
        color:#8566aa;
    }
    .edit_cont{
        font-family: 'roboto',sans-serif;
    }
</style>
    <div class="container edit_cont">
        <h3 style="padding:1rem;background:#dbdbdb;border-radius:5px;margin:1rem 1rem;">
            <center>Edit Question</center>
        </h3>
        <div class="col">
            <form action="<?= base_url('volunteer/Dashboard/editsub_question/' . $all_ques['id']) ?>" method="POST">
                <div class="">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Q. </div>
                        </div>
                        <input type="text" class="form-control" height="50px" name="mcq_question" id="question" value="<?= $all_ques['question'] ?>">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">A. </div>
                        </div>
                        <input type="text" class="form-control" height="50px" name="answer" id="question" value="<?= $all_ques['answer'] ?>">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">E. </div>
                        </div>
                        <input type="text" class="form-control" height="50px" name="explanation" id="question" value="<?= $all_ques['explanation'] ?>">
                    </div>
                   
                    

                    <br>
                    <div style="display: flex;justify-content:space-between;align-items:center">
                    <button type="submit" class="btn save-btn">
                        Save Question
                    </button>
                    <a href="<?= base_url('volunteer/Dashboard/subjective') ?>" class="btn back-btn">Back</a>
                    </div>
                  

                </div>
            </form>
        </div>
      
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>