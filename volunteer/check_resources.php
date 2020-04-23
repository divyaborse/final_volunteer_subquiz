<div class="container">
    <div class="p-4 m-4 table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Class</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Chapter </th>
                    <th scope="col">Topic </th>
                    <th scope="col">Link </th>
                    <th scope="col">Board </th>
                    <th scope="col">Type</th>
                    <th scope="col">Language</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result) :
                    $sno = 0;
                    foreach ($result as $rows) : ?>
                        <tr>
                            <th scope="row"><?= ++$sno ?></th>
                            <td><?= $rows['name'] ?></td>
                            <td><?= $rows['class'] ?></td>
                            <td><?= $rows['subject'] ?></td>
                            <td><?= $rows['chapter'] ?></td>
                            <td><?= $rows['topic2'] ?></td>
                            <td><?= $rows['link'] ?></td>
                            <td><?= $rows['type'] ?></td>
                            <td><?= strtoupper($rows['board']) ?></td>
                            <td>
                                <?php
                                if ($rows['language'] == '1')
                                    echo 'English';
                                elseif ($rows['language'] == '2')
                                    echo 'Hindi';
                                ?>
                            </td>
                        </tr>
                <?php endforeach;
                else :
                    echo 'No Record Found';

                endif;

                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>