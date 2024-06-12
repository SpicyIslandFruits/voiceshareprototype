# `/internal`

Private application and library code.

# `/web`

Web application specific components: static web assets, server side templates and SPAs.

# Dependencies

`sudo apt install php7.4-mysql php7.4-mbstring`

# TODO

- htaccess書く。多分web以下だけ許可でいい
- robotx.txt書く

# Memo

起動方法

1. `cd ./build && docker compose up`
2. `php -S 0.0.0.0:8000`
