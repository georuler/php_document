## mosquitto
- install
```ssh
sudo apt-get install mosquitto
```

- status
```ssh
sudo /etc/init.d/mosquitto status
```

- client install
```ssh
sudo apt-get install mosquitto-clients
```

## test

- subscribe
```ssh
mosquitto_sub -t /test
```

- publish
```ssh
mosquitto_pub -t /test -m "test"
```