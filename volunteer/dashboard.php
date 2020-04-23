<div class="container">
    <div class="jumbotron shadow border border-danger mt-3">
        <h4>Welcome, <?= $this->session->userdata('quiz_volunteer')['name'] ?></h4>
        <?php
        if ($this->session->flashdata('skillAddSuccess')) {
            echo '<div class="alert alert-success">' . $this->session->flashdata('skillAddSuccess') . ' </div>';
        } else if ($this->session->flashdata('skillAddFail')) {
            echo '<div class="alert alert-danger">' . $this->session->flashdata('skillAddFail') . ' </div>';
        }
        $roundVal = array(" Round 1 ", " Round 1 ", " Round 2", " Weekly Quiz ");
        ?>
        <p class="lead">This is your dashboard, click below to start adding questions...</p>
        <hr class="my-4">
        <div class="d-flex justify-content-center">
            <div class="row text-center">
                <a class="btn btn-outline-primary mb-2 mx-4" href="<?= base_url('volunteer/Dashboard/mcqQuestion') ?>" role="button">MCQ Questions</a>
                <a class="btn btn-outline-primary mb-2 mx-4" href=" " role="button">Paragraph Questions</a>
                <a class="btn btn-outline-primary mb-2 mx-4" href="<?= base_url('volunteer/Dashboard/subjective') ?> " role="button">Subjective Questions</a>
                <a class="btn btn-outline-primary mb-2 mx-4" href=" " data-toggle="modal" data-target="#uploadModal" role="button">Upload Resource</a>
            </div>
        </div>
    </div>
</div>

<!-- Upload Material Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Utility</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-inline " enctype="multipart/form-data" method="post" action="<?= base_url('volunteer/Dashboard/add_upload')?>">
                    <div class="row p-2">
                        <div class="form-group col-md-4">
                            <label>Class</label>
                            <select name="class" required id="class" class="form-control">
                                <option disabled selected value> -- select an option --
                                </option>

                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>

                            </select>

                        </div>
                        <div class="form-group col-md-4">
                            <label>Board</label>
                            <select name="board" required id="board" class="form-control">
                                <option disabled selected value> -- select an option --
                                </option>
                                <option value="cbse">CBSC</option>
                                <option value="ncert">NCERT</option>

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Subject</label>
                            <select name="subject" required id="subject" class="form-control">
                                <option disabled selected value> -- select an option --
                                </option>
                                <option value="Mathematics"> Mathematics</option>
                                <option value="Physics">Physics </option>
                                <option value="Biology"> Biology</option>
                                <option value="English Core">English Core </option>
                                <option value="English Elective"> English Elective</option>
                                <option value="Chemistry"> Chemistry</option>
                                <option value="Computer Science for XI">Computer Science for XI </option>
                                <option value="Computer Science for XII">Computer Science for XII </option>
                                <option value="Informatics Practices XI">Informatics Practices XI </option>
                                <option value="Informatics Practices XII"> Informatics Practices XII</option>
                                <option value="Accountancy"> Accountancy</option>
                                <option value="Business Studies"> Business Studies</option>
                                <option value="Economics">Economics </option>
                                <option value="Physical Education">Physical Education </option>
                                <option value="Bio – Technology">Bio – Technology </option>
                                <option value="Political Science">Political Science </option>
                                <option value="Engineering Graphics"> Engineering Graphics</option>
                                <option value="Entrepreneurship">Entrepreneurship </option>
                                <option value="Fine Arts">Fine Arts </option>
                                <option value="Home Science">Home Science </option>
                                <option value="Geography"> Geography</option>
                                <option value="History"> History</option>
                                <option value="Hindi Aadhar">Hindi Aadhar </option>
                                <option value="Hindi Aichchik"> Hindi Aichchik</option>
                                <option value="Legal Studies">Legal Studies </option>
                                <option value="Psychology">Psychology </option>
                                <option value="Sociology">Sociology </option>
                                <option value="NCC">NCC </option>

                                <option value="Hindi">Hindi</option>
                                <option value="English">English</option>
                                <option value="Maths">Maths</option>
                                <option value="Science">Science</option>
                                <option value="Social Science">Social Science</option>
                                <option value="Sanskrit (Optional)">Sanskrit (Optional)</option>
                                <option value="Environmental Studies">Environmental Studies</option>
                                <option value="EHindi Course A"> Hindi Course A</option>
                                <option value="Hindi Course B">Hindi Course B</option>
                            </select>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="form-group col-md-6">
                            <label>Chapter No.</label>
                            <select class="form-control" required name="chapterN">
                                <option selected disabled value="">Chapter Number</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Chapter Name</label>
                            <input type="text" name="chapter" class="form-control">
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="form-group col-lg-6">

                            <label>Topic of pdf</label>
                            <input type="text" name="topic" class="form-control">
                            <input name="file" type="file" id="image" style="width: 200px;" class="form-control" placeholder=".pdf">
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Topic of video</label>
                            <input type="text" name="topic2" class="form-control">
                            <input name="urls" type="text" id="url" class="form-control" placeholder="https://www.youtube.com/embed/0vuHnTWs-VY">
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="form-group col-lg-6">
                            <label>Language</label>
                            <select name="language" required id="language" class="form-control">
                                <option value="1" selected>English</option>
                                <option value="2">Hindi</option>

                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Type</label>
                            <select name="type" required id="type" class="form-control">

                                <option value="">----Select----</option>
                                <option value="general">General</option>
                                <option value="live">Live</option>

                            </select>
                        </div>
                    </div>
                    <div class="modal-footer col-md-12">
                        <button type="submit" class="btn btn-primary btn-lg float-left">ADD</button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>