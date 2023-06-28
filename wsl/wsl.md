## wsl error
- error message
```code
System has not been booted with systemd as init system (PID 1). Can't operate. Failed to connect to bus: Host is down
```

- 실행
```code
sudo apt-get update && sudo apt-get install -yqq daemonize dbus-user-session fontconfig

sudo daemonize /usr/bin/unshare --fork --pid --mount-proc /lib/systemd/systemd --system-unit=basic.target

exec sudo nsenter -t $(pidof systemd) -a su - $LOGNAME

snap version
```