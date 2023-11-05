<!--判断管理员权限-->
<?php 
include_once("checkAdmin.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <title>Mitglied Management System</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <!--引入nav栏-->
  <div class="main"><?php include_once 'nav.php';  ?></div>

  <!--向管理员显示数据库资料-->
  <div>
    <?php 
      include_once ('conn.php');  //引入数据库，并将数据库表格info循环输出到下面的表格中
      include_once('page.php');  //分页函数文件

      //统计表格内id列的数据个数
      $sql ="select count(id) as total from info"; //SQL语句,使用聚合函数count统计记录总数
      $result = mysqli_query($conn, $sql);   //mysqli_connect()函数，执行SQL语句，并储存查询结果
      $info = mysqli_fetch_array($result); //mysqli_fetch_array()函数：从数据库查询结果中取一行数据，把它们以键值对的形式存入一个数组中
      $total = $info['total']; //从info数组中取出total的value，并赋值给total变量- 得到总记录数
      $perPage = 3; //设置每页显示2条记录
      $page = $_GET['page'] ?? 1; //读取当前页码,如果不存在则设置为1
      paging($total, $perPage); //调用分页函数
      //再次查询数据库，进行分页操作，引用分页文件page.php中的全局变量$firstCount和$perPage
      $sql = "SELECT * FROM info order by id desc limit $firstCount,$perPage";  //把查询数据库语句，存储为变量: 查询数据库中的info表，按照id降序排列（新注册的会员在最前面）
      $result = mysqli_query($conn, $sql);   //mysqli_connect()是MySQLi函数，用于执行SQL查询，并储存查询结果
    ?>
  <table id="admin_table"   border="1" cellspacing="0" cellpadding="10" style="border-collapse: collapse" align="center" width="90%">
    <h1>Mitglied Information:</h1>
    <tr style="font-weight: bold;">    <!--表头内容加粗-->
      <td>No.</td>
      <td>Vorname</td>
      <td>Nachname</td>
      <td>Email</td>
      <td>Stadt</td>
      <td>Admin</td>
      <td>Bedienung</td>
    </tr>
    <?php
        $i= ($page - 1) * $perPage + 1;  //定义一个变量，在每个分页中显示序号
        while ($info = mysqli_fetch_array($result)){   //赋值语句：从数据库查询结果中取一条数据集，然后赋值给info--然后进入无限循环判断，如果有内容，则循环一直进行下去
    ?>  
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $info['vorname']; ?></td>
            <td><?php echo $info['nachname']; ?></td>
            <td><?php echo $info['email']; ?></td>
            <td><?php echo $info['stadt']; ?></td>
            <td><?php echo $info['admin']?'Ja':'Nein'; ?></td>
            <td>
              <a style="text-decoration: underline;" href="modify.php?vorname=<?php echo $info['vorname']; ?>&nachname=<?php echo $info['nachname']; ?>&source=admin&page=<?php echo $page; ?>">Daten ändern</a>
            <?php 
              if ($info['vorname'] <> 'admin') { 
            ?>
                <a style="text-decoration: underline;" href="javascript:del(<?php echo $info['id']; ?>,'<?php echo $info['vorname']; ?>','<?php echo $info['nachname']; ?>');">Delete Kunden</a>
            <?php
              }else{
                  echo "<span style='color:gray'>Delete Kunden</span> ";
              }?> 
            <?php 
              if ($info['vorname'] != 'admin') {
                if ($info['admin']) { 
            ?>    <a href="setAdmin.php?action=0&userID=<?php echo $info['id']; ?>">Delete Admin</a>
            <?php 
                }else{ 
            ?>    <a href="setAdmin.php?action=1&userID=<?php echo $info['id']; ?>">Set Admin</a>
            <?php 
                }
              }else{ 
            ?>
                <span style="color: gray">Delete Admin</span>
            <?php 
              } 
            ?>
            </td>
            </tr>
            <?php
              $i++;
            }
            ?>
        
  </table>
  <h6 style="text-align: center;margin:10px auto;"><?php echo $pageNav ?></h6>
</div>

<script>
    function del(id,vorname,nachname){
        if(confirm('Mitgled : ' + vorname +' '+ nachname + ' löschen ?')){
            location.href = 'del.php?id=' + id + '&vorname=' + vorname + '&nachname='+ nachname;
        }
    }
</script>

<!--Bootstrap 样式-->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>
</html>