<?php

require __DIR__ . '/../../vendor/autoload.php';

// URLからaccount_idを取得する
if (isset($_GET['id'])) {
    $account_id = $_GET['id'];
} else {
    echo "Account IDが指定されていません。";
    exit();
}

$profileRepo = new \mysql\ProfileRepo();
$app = new \actor\App($profileRepo);
$controller = new \actor\Controller($app);
try {
    $profile = $controller->handleGetOrInitProfile(new \common\Id($account_id));
} catch (\Exception $e) {
    echo "Profile not found";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ表示</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        label {
            font-size: small;
        }

        .profile-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .profile-container h1 {
            text-align: center;
            color: #333;
        }

        .profile-container label {
            margin-bottom: 5px;
            color: #555;
        }

        .profile-container .field-value {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
            flex: 1;
        }

        .profile-container div {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .profile-container .radio-group label,
        .profile-container .checkbox-group label {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }

        .profile-container label {
            flex: 0 0 180px; /* ラベルの固定幅 */
        }
    </style>
</head>
<body>
<div class="profile-container">
    <h1>声優プロフィール</h1>
    <!-- General Profile Display -->
    <div>
        <label>表示名</label>
        <div class="field-value"><?php echo htmlspecialchars($profile->displayName, ENT_QUOTES, 'UTF-8'); ?></div>
    </div>
    <div>
        <label>声優ランク</label>
        <div class="field-value">
            <?php
            switch ($profile->category) {
                case \actor\Category::PROFESSIONAL_VETERAN:
                    echo 'プロベテラン';
                    break;
                case \actor\Category::PROFESSIONAL_ROOKIE:
                    echo 'プロルーキー';
                    break;
                case \actor\Category::AMATEUR:
                    echo '新人・アマチュア';
                    break;
                default:
                    echo '不明';
            }
            ?>
        </div>
    </div>
    <div>
        <label>自己PR</label>
        <div class="field-value"><?php echo nl2br(htmlspecialchars($profile->selfPromotion, ENT_QUOTES, 'UTF-8')); ?></div>
    </div>
    <div>
        <label>価格</label>
        <div class="field-value"><?php echo htmlspecialchars($profile->price, ENT_QUOTES, 'UTF-8'); ?> 円/30分</div>
    </div>

    <!-- R-related Options Display -->
    <div>
        <label>セクシャル（R的要素）表現</label>
        <div class="field-value"><?php echo $profile->r->ok ? '許可' : '不可'; ?></div>
    </div>
    <div>
        <label>R作品</label>
        <div class="field-value"><?php echo htmlspecialchars($profile->r->price, ENT_QUOTES, 'UTF-8'); ?> 円/30分</div>
    </div>
    <div>
        <label>R過激表現オプション</label>
        <div class="field-value"><?php echo $profile->r->hardOk ? '許可' : '不可'; ?></div>
    </div>
    <div>
        <label>過激オプション割増</label>
        <div class="field-value"><?php echo htmlspecialchars($profile->r->hardSurcharge, ENT_QUOTES, 'UTF-8'); ?></div>
    </div>
</div>
</body>
</html>

