import os
import re

base_dir = r"c:\xampp\htdocs\kost-app\resources\views"
dirs = [
    'regions', 'estates', 'units', 'users', 'leads', 
    'facilities', 'maintenances', 'announcements', 
    'bookings', 'billings', 'expenses', 'utility_readings', 
    'complaints', 'visitors', 'parcels'
]

def replace_classes(content):
    # Special button texts first to prevent them being changed to dark brown
    content = content.replace('uppercase text-white transition-all hover:-translate-y-1', 'uppercase text-white transition-all hover:-translate-y-1')
    content = content.replace('uppercase text-white transition-all hover:opacity-90', 'uppercase text-white transition-all hover:opacity-90')

    # Colors & Typography
    # But wait, we can just replace text-white everywhere except in gradients
    content = content.replace('text-white', 'text-[#3e342f]')
    # Re-fix the buttons that got replaced
    content = content.replace('uppercase text-[#3e342f] transition-all hover:-translate-y-1', 'uppercase text-white transition-all hover:-translate-y-1')
    content = content.replace('uppercase text-[#3e342f] transition-all hover:opacity-90', 'uppercase text-white transition-all hover:opacity-90')

    content = content.replace('text-slate-400', 'text-stone-500')
    content = content.replace('text-slate-500', 'text-stone-500')
    content = content.replace('text-slate-300', 'text-stone-600')
    
    # Backgrounds & Borders
    content = content.replace('bg-white/5', 'bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)]')
    content = content.replace('border-white/10', 'border-[rgba(183,92,28,0.1)]')
    content = content.replace('bg-black/20', 'bg-[#fdfbf7]')
    content = content.replace('divide-white/5', 'divide-stone-100')
    content = content.replace('bg-slate-900', 'bg-[#fdfbf7]')
    content = content.replace('bg-slate-800', 'bg-white')
    content = content.replace('backdrop-blur-xl', '')
    
    # Buttons & Accents
    content = content.replace('from-amber-400 to-amber-400', 'from-[#b75c1c] to-[#a65319]')
    content = content.replace('text-amber-400', 'text-[#b75c1c]')
    content = content.replace('bg-amber-500/10', 'bg-[rgba(183,92,28,0.1)]')
    content = content.replace('border-amber-500/20', 'border-[rgba(183,92,28,0.2)]')
    content = content.replace('hover:bg-amber-500/20', 'hover:bg-[rgba(183,92,28,0.2)]')
    
    # Danger Buttons
    content = content.replace('bg-red-500/10', 'bg-rose-50')
    content = content.replace('text-red-400', 'text-rose-600')
    content = content.replace('border-red-500/20', 'border-rose-100')
    content = content.replace('hover:bg-red-500/20', 'hover:bg-rose-100')
    
    # Inputs
    content = content.replace('focus:border-amber-500/50', 'focus:border-[#b75c1c]')
    content = content.replace('focus:ring-amber-500/50', 'focus:ring-[#b75c1c]')
    
    # Inline styles
    content = content.replace('style="color:#d97706;"', 'class="text-[#b75c1c] block text-[10px] font-black uppercase tracking-[0.3em] mb-2"')
    content = content.replace('rgba(16,185,129,0.3)', 'rgba(183,92,28,0.3)')
    
    return content

count = 0
for d in dirs:
    path = os.path.join(base_dir, d)
    if os.path.exists(path):
        for root, _, files in os.walk(path):
            for file in files:
                if file.endswith('.blade.php'):
                    filepath = os.path.join(root, file)
                    with open(filepath, 'r', encoding='utf-8') as f:
                        content = f.read()
                    
                    new_content = replace_classes(content)
                        
                    if new_content != content:
                        with open(filepath, 'w', encoding='utf-8') as f:
                            f.write(new_content)
                        count += 1
                        
print(f"Fix completed! Modified {count} files.")
