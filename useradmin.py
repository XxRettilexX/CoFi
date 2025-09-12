import tkinter as tk
from tkinter import messagebox
import mysql.connector
from werkzeug.security import generate_password_hash  # per hash sicuro della password

# Connessione al DB (modifica con i tuoi dati)
db_config = {
    'host': '127.0.0.1',
    'user': 'root',
    'password': '',       # inserisci la password del DB
    'database': 'CoFi'
}

def create_admin():
    name = entry_name.get()
    email = entry_email.get()
    password = entry_password.get()

    if not name or not email or not password:
        messagebox.showwarning("Errore", "Tutti i campi sono obbligatori")
        return

    hashed_password = generate_password_hash(password)

    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()

        # Inserisce l'admin nella tabella users
        cursor.execute("""
            INSERT INTO users (name, email, password, role)
            VALUES (%s, %s, %s, %s)
        """, (name, email, hashed_password, 'admin'))

        conn.commit()
        cursor.close()
        conn.close()
        messagebox.showinfo("Successo", f"Admin '{name}' creato correttamente!")
        entry_name.delete(0, tk.END)
        entry_email.delete(0, tk.END)
        entry_password.delete(0, tk.END)

    except mysql.connector.Error as err:
        messagebox.showerror("Errore DB", f"Errore: {err}")

# Interfaccia Tkinter
root = tk.Tk()
root.title("Crea Admin")
root.geometry("400x250")

tk.Label(root, text="Nome").pack(pady=5)
entry_name = tk.Entry(root, width=40)
entry_name.pack(pady=5)

tk.Label(root, text="Email").pack(pady=5)
entry_email = tk.Entry(root, width=40)
entry_email.pack(pady=5)

tk.Label(root, text="Password").pack(pady=5)
entry_password = tk.Entry(root, show="*", width=40)
entry_password.pack(pady=5)

tk.Button(root, text="Crea Admin", command=create_admin, bg="#3b82f6", fg="white").pack(pady=15)

root.mainloop()
