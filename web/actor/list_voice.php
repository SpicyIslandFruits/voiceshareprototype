<?php

require __DIR__ . '/middleware.php';

$session = authenticate();

if ($session->role != \auth\Role::ACTOR && $session->role != \auth\Role::ADMIN) {
    echo "<a href='../auth/signin.html'>声優の方はこちらからログインしてください。</a>";
    exit();
}

$allVoices = getVoiceController()->getAll($session->accountId);

foreach ($allVoices as $voice) {
    $selected_age_tag = '';

    foreach ($voice->tags as $tag) {
        if ($tag->category == '年代別タグ') {
            $selected_age_tag = $tag->name;
            break;
        }
    }

    $selected_character_tag = '';
    foreach ($voice->tags as $tag) {
        if ($tag->category == 'キャラ別タグ') {
            $selected_character_tag = $tag->name;
            break;
        }
    }

    echo '<div><a href="' . "../../uploads/voices/" . htmlspecialchars($voice->getFullname()) . '">' . htmlspecialchars($voice->title) . '</a></div>';
    echo '<div>filename: ' . htmlspecialchars($voice->filename) . '</div>';
    echo '<div>mimeType: ' . htmlspecialchars($voice->mimeType) . '</div>';
    echo '<div>createdAt: ' . htmlspecialchars($voice->createdAt->format('Y-m-d')) . '</div>';

    // Form to edit the tag of the voice
    echo '<form method="POST" action="edit_tag.php">';
    echo '<input type="hidden" id="voice_id" name="voice_id" value="' . htmlspecialchars($voice->voiceId->value) . '"><br>';
    echo '<label for="voice_title">Voice Title:</label>';
    echo '<input type="text" id="voice_title" name="voice_title" value="' . htmlspecialchars($voice->title) . '"><br>';

    echo '<label for="age_tag">Age Tag:</label>';
    echo '<select id="age_tag" name="age_tag">';
    echo '<option value="10代"' . ($selected_age_tag === '10代' ? ' selected' : '') . '>10代</option>';
    echo '<option value="20代"' . ($selected_age_tag === '20代' ? ' selected' : '') . '>20代</option>';
    echo '<option value="30代以上"' . ($selected_age_tag === '30代以上' ? ' selected' : '') . '>30代以上</option>';
    echo '</select><br>';

    echo '<label for="character_tag">Character Tag:</label>';
    echo '<select id="character_tag" name="character_tag">';
    echo '<option value="大人しい"' . ($selected_character_tag === '大人しい' ? ' selected' : '') . '>大人しい</option>';
    echo '<option value="快活"' . ($selected_character_tag === '快活' ? ' selected' : '') . '>快活</option>';
    echo '<option value="セクシー・渋め"' . ($selected_character_tag === 'セクシー・渋め' ? ' selected' : '') . '>セクシー・渋め</option>';
    echo '</select><br>';

    echo '<input type="submit" value="Edit Tag">';
    echo '</form>';
}
