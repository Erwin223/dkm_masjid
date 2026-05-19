import re
import glob

files = [
    r'resources\views\admin\kas_masuk\index.blade.php',
    r'resources\views\admin\kas_keluar\index.blade.php',
    r'resources\views\admin\zakat\distribusi_index.blade.php',
    r'resources\views\admin\kegiatan\jadwal_kegiatan.blade.php',
    r'resources\views\admin\donasi\donasi_keluar_index.blade.php',
    r'resources\views\admin\zakat\penerimaan_index.blade.php',
    r'resources\views\admin\donasi\donasi_masuk_index.blade.php'
]

# The pattern captures the variable name (e.g., $kas, $item, $d, $k)
# We want to replace the whole block from @if($VAR->deletionRequest) up to the matching @else for the deletion button.

pattern = re.compile(r"(@if\(\s*(\$\w+)->deletionRequest\s*\))(.*?)(?=\s*@else\s*<td style=\"text-align:center;\">\s*<form id=\"(del-|hapus-))", re.DOTALL)

for filepath in files:
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()

        def replacer(match):
            prefix = match.group(1) # @if($kas->deletionRequest)
            var_name = match.group(2) # $kas
            
            replacement = f'''{prefix}
                        @if(auth()->user()->role == 'ketua')
                            <td colspan="2" style="text-align:center;">
                                <div style="margin-bottom:6px;">
                                    <span style="font-size:12px;color:#b45309;background:#fef3c7;padding:4px 10px;border-radius:12px;font-weight:600;">Menunggu Dihapus</span>
                                </div>
                                <div style="display:flex; justify-content:center; gap:4px;">
                                    <form action="{{{{ route('admin.deletion_approvals.approve', {var_name}->deletionRequest->id) }}}}" method="POST">
                                        @csrf
                                        <button style="background: #10b981; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 11px;" type="submit" title="Setuju" onclick="return confirm('Yakin setujui?')"><i class="fa fa-check"></i> Setuju</button>
                                    </form>
                                    <form action="{{{{ route('admin.deletion_approvals.reject', {var_name}->deletionRequest->id) }}}}" method="POST">
                                        @csrf
                                        <button style="background: #ef4444; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 11px;" type="submit" title="Tidak" onclick="return confirm('Yakin tolak?')"><i class="fa fa-times"></i> Tidak</button>
                                    </form>
                                </div>
                            </td>
                        @else
                            <td colspan="2" style="text-align:center;">
                                <span style="font-size:12px;color:#b45309;background:#fef3c7;padding:4px 10px;border-radius:12px;font-weight:600;">Menunggu Dihapus</span>
                            </td>
                        @endif'''
            return replacement

        new_content, num_subs = pattern.subn(replacer, content)
        
        if num_subs > 0:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(new_content)
            print(f"Fixed {filepath}")
        else:
            print(f"Pattern not found in {filepath}")
    except Exception as e:
        print(f"Error on {filepath}: {e}")
