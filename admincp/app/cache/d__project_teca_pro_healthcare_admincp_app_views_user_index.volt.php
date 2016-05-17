<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading head-border">
                <?= $labelkey['user.lbl_list'] ?>
            </header>
            <div class="panel-body">
                <form method="get" action="" class="form-horizontal tasi-form">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="form" class="btn btn-success m-b-10"><?= $labelkey['general.btn_addnew'] ?></a>
                        </div>
                        <div class="col-md-6 text-right">
                            <input type="text" name="q" class="form-control" placeholder="<?= $labelkey['general.lbl_search'] ?>..." value="<?= $q ?>" />
                        </div>
                    </div>
                </form>

                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?= $labelkey['user.lbl_username'] ?></th>
                        <th><?= $labelkey['user.lbl_creator'] ?></th>
                        <th><?= $labelkey['general.lbl_action'] ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($listdata as $item) { ?>
                        <tr>
                            <td><?= $item->id ?></td>
                            <td><?= $item->username ?></td>
                            <td><?= $item->User->username ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-default" title="<?= $labelkey['general.btn_edit'] ?>" href="form?id=<?= $item->id ?>"><i class="zmdi zmdi-edit"></i></a>
                                    <a class="btn btn-default" onclick="return confirm('<?= $labelkey['general.lbl_sure'] ?>');" title="<?= $labelkey['general.btn_delete'] ?>" href="delete?id=<?= $item->id ?>"><i class="zmdi zmdi-delete"></i></a>
                                    <a class="btn btn-default" title="<?= $labelkey['user.lbl_role'] ?>" href="role?id=<?= $item->id ?>"><i class="zmdi zmdi-account"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
                
<div class="row text-center">
    <div class="col-sm-12">
        <?php if ($painginfo['rowcount'] > 0) { ?>
        <ul class="pagination">
            <ul class="pagination">
                <li class="prev"><a class="button" href="<?= $painginfo['currentlink'] ?>&p=<?= ($painginfo['page'] - 1 <= 1 ? 1 : $painginfo['page'] - 1) ?>">Prev</a></li>
                <?php foreach ($painginfo['rangepage'] as $index => $item) { ?>
                    <li class="page-<?= $index + 1 ?> <?= ($item == $painginfo['page'] ? 'active' : '') ?>"><a class="button" href="<?= $painginfo['currentlink'] ?>&p=<?= $item ?>"><?= $item ?></a></li>
                <?php } ?>
                <li class="next"><a class="button" href="<?= $painginfo['currentlink'] ?>&p=<?= ($painginfo['page'] + 1 >= $painginfo['totalpage'] ? $painginfo['totalpage'] : $painginfo['page'] + 1) ?>">Next</a></li>
            </ul>
        </ul>
        <?php } else { ?>
        <p class="text-success m-t-10">Không tìm thấy kết quả nào</p>
        <?php } ?>
    </div>
</div>
            </div>
        </section>
    </div>
</div>