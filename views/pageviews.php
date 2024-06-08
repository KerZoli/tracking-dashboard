<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/list.css">
</head>
<body>
    <div class="container">
        <h2>Page views</h2>

        <section id="filters">
        <form>
            <label for="client">Client:</label>
            <select id="client" name="client">
                <option <?php if(isset($_GET['client']) && $_GET['client'] === ''): ?> selected <?php endif ?> value="">None</option>
                <?php foreach($clients as $client): ?>
                    <option <?php if(isset($_GET['client']) && $_GET['client'] === $client->id): ?> selected <?php endif ?>
                            value="<?=$this->e($client->id)?>"><?=$this->e($client->id)?>
                    </option>
                <?php endforeach ?>
            </select>
            <label for="interval-start">Interval start date:</label>
            <input
                type="datetime-local"
                id="interval-start"
                name="start_date"
                value="<?=isset($_GET['start_date']) ? $this->e($_GET['start_date']) : ''?>"
            />
            <label for="interval-end">Interval end date:</label>
            <input
                type="datetime-local"
                id="interval-end"
                name="end_date"
                value="<?=isset($_GET['end_date']) ? $this->e($_GET['end_date']) : ''?>"
            />
            <input type="submit" value="Filter" />
        </form>
        </section>
        <section id="page-view-list">
            <table>
                <tr>
                    <th>Client</th>
                    <th>Page</th>
                    <th>Nr of views</th>
                </tr>

                <?php foreach($statistics as $stat): ?>
                    <tr>
                        <td><?=$this->e($stat->client_id)?></td>
                        <td><?=$this->e($stat->pathname)?></td>
                        <td><?=$this->e($stat->unique_users)?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </section>
    </div>
</body>
</html>