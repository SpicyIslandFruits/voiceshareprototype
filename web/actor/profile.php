<?php

require __DIR__ . '/middleware.php';

$session = authenticate();

$profile = getProfileController()->handleGetOrInitProfile($session->accountId);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ編集</title>
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

        .edit-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .edit-container h1 {
            text-align: center;
            color: #333;
        }

        .edit-container label {
            margin-bottom: 5px;
            color: #555;
        }

        .edit-container input[type="text"],
        .edit-container input[type="number"],
        .edit-container textarea {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .edit-container input[type="checkbox"] {
            margin-right: 10px;
        }

        .edit-container div {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .edit-container button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .edit-container button:hover {
            background-color: #0056b3;
        }

        .edit-container .checkbox-group label {
            display: flex;
            align-items: center;
        }

        .edit-container label {
            flex: 0 0 180px; /* ラベルの固定幅 */
        }
    </style>
</head>
<body>
<div class="edit-container">
    <h1>マイページ</h1>
    <!-- General Profile Form -->
    <form action="update_profile.php" method="post" id="profile_form">
        <div>
            <label for="displayName">表示名</label>
            <input type="text" id="displayName" name="displayName"
                   value="<?php echo htmlspecialchars($profile->displayName, ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div>
            <label>声優ランク</label>
            <div class="radio-group">
                <label for="professionalVeteran">
                    <input type="radio" id="professionalVeteran" name="category"
                           value="<?php echo \actor\Category::PROFESSIONAL_VETERAN; ?>" <?php echo \actor\Category::PROFESSIONAL_VETERAN === $profile->category ? 'checked' : ''; ?>>
                    プロベテラン
                </label>
                <label for="professionalRookie">
                    <input type="radio" id="professionalRookie" name="category"
                           value="<?php echo \actor\Category::PROFESSIONAL_ROOKIE; ?>" <?php echo \actor\Category::PROFESSIONAL_ROOKIE === $profile->category ? 'checked' : ''; ?>>
                    プロルーキー
                </label>
                <label for="amateur">
                    <input type="radio" id="amateur" name="category"
                           value="<?php echo \actor\Category::AMATEUR; ?>" <?php echo \actor\Category::AMATEUR === $profile->category ? 'checked' : ''; ?>>
                    新人・アマチュア
                </label>
            </div>
        </div>
        <div>
            <label for="selfPromotion">自己PR</label>
            <textarea id="selfPromotion"
                      name="selfPromotion"><?php echo htmlspecialchars($profile->selfPromotion, ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        <div>
            <label for="price">価格</label>
            <input type="number" id="price" name="price"
                   value="<?php echo htmlspecialchars($profile->price, ENT_QUOTES, 'UTF-8'); ?>">
            円/30分
        </div>
        <div>
            <button type="submit">プロフィール更新</button>
        </div>
    </form>
    <script>
        document.getElementById('profile_form').addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('update_profile.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    // Handle the response from the server
                    window.alert("更新しました")
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Handle any errors
                });
        });
    </script>

    <!-- Profile Image Section -->
    <form action="update_thumbnail.php" method="post" enctype="multipart/form-data" id="profile_image_form">
        <div>
            <label for="profileImage">プロフィール画像</label>
            <?php
            $profileImage = $profile->profileImage;

            if ($profileImage !== null) {
                $imageSrc = "../../uploads/actor/" . htmlspecialchars($profileImage->getFullname());
                $altText = "プロフィール画像";
                echo '<img src="' . $imageSrc . '" alt="' . $altText . '" style="max-width: 500px;">';
            } else {
                echo '<p>プロフィール画像が見つかりません</p>';
            }
            ?>
            <input type="file" id="profile_image" name="profile_image" accept="image/*">
        </div>
        <div>
            <button type="submit">画像更新</button>
        </div>
    </form>
    <script>
        document.getElementById('profile_image_form').addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('update_thumbnail.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    window.location.assign('')
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Handle any errors
                });
        });
    </script>

    <!-- R-related Options Form -->
    <form action="update_r.php" method="post" id="r_options_form">
        <div>
            <label for="ok">セクシャル（R的要素）表現</label>
            <input type="checkbox" id="ok" name="ok" <?php echo $profile->r->ok ? 'checked' : ''; ?>>
        </div>
        <div>
            <label for="price">R作品</label>
            <input type="number" id="price" name="price"
                   value="<?php echo htmlspecialchars($profile->r->price, ENT_QUOTES, 'UTF-8'); ?>"> 円/30分
        </div>
        <div>
            <label for="hardOk">R過激表現オプション</label>
            <input type="checkbox" id="hardOk" name="hardOk" <?php echo $profile->r->hardOk ? 'checked' : ''; ?>>
        </div>
        <div>
            <label for="hardSurcharge">過激オプション割増</label>
            <input type="number" id="hardSurcharge" name="hardSurcharge"
                   value="<?php echo htmlspecialchars($profile->r->hardSurcharge, ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div>
            <button type="submit">Rオプション更新</button>
        </div>
    </form>
    <script>
        document.getElementById('r_options_form').addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('update_r.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    // Handle the response from the server
                    window.alert("更新しました")
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Handle any errors
                });
        });
    </script>

    <h3>音声投稿</h3>
    <form action="upload_voice.php" method="post" enctype="multipart/form-data" id="voice_form">
        <div>
            <label for="voiceTitle">音声タイトル</label>
            <input type="text" id="voiceTitle" name="voiceTitle">
        </div>
        <label for="audio">音声ファイルを選択 (mp3, wav, ogg):</label>
        <input type="file" id="audio" name="audio" accept=".mp3, .wav, .ogg" required>
        <input type="submit" value="アップロード">
    </form>
    <script>
        document.getElementById('voice_form').addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('upload_voice.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    // Handle the response from the server
                    window.alert("更新しました")
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Handle any errors
                });
        });
    </script>
</div>
<a href="list_voice.php">音声投稿一覧</a>
</body>
</html>
