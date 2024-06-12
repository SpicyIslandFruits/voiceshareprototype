#! /bin/bash

cd "$(dirname "$0")/.." || exit 1

# Composerをダウンロード
wget -O composer-setup.php https://getcomposer.org/installer

# ハッシュ値を検証（任意）
EXPECTED_HASH="$(curl -sS https://composer.github.io/installer.sig)"
ACTUAL_HASH="$(sha384sum composer-setup.php | awk '{ print $1 }')"

if [ "$EXPECTED_HASH" != "$ACTUAL_HASH" ]; then
    >&2 echo 'ERROR: Invalid installer hash'
    rm composer-setup.php
    exit 1
fi

# Composerをインストール
php composer-setup.php --install-dir=.

# インストーラーを削除
rm composer-setup.php

# composer installの実行
php composer.phar install
