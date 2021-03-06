<? /*
    LibreSSL - CAcert web application
    Copyright (C) 2004-2008  CAcert Inc.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; version 2 of the License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
*/ ?>
<table align="center" valign="middle" border="0" cellspacing="0" cellpadding="0" class="wrapper">
  <tr>
    <td colspan="5" class="title"><?=_("OpenPGP Keys")?></td>
  </tr>
  <tr>
    <td class="DataTD"><?=_("Status")?></td>
    <td class="DataTD"><?=_("Email Address")?></td>
    <td class="DataTD"><?=_("Expires")?></td>
    <td class="DataTD"><?=_("Key ID")?></td>

<?
	$query = "select UNIX_TIMESTAMP(`issued`) as `issued`,
			UNIX_TIMESTAMP(`expire`) - UNIX_TIMESTAMP() as `timeleft`,
			UNIX_TIMESTAMP(`expire`) as `expired`,
			`expire` as `expires`, `id`, `level`, 
			`email`,`keyid` from `gpg` where `memid`='".intval($_SESSION['profile']['id'])."'
			ORDER BY `issued` desc";
	$res = mysql_query($query);
	if(mysql_num_rows($res) <= 0)
	{
?>
  <tr>
    <td colspan="5" class="DataTD"><?=_("No OpenPGP keys are currently listed.")?></td>
  </tr>
<? } else {
	while($row = mysql_fetch_assoc($res))
	{
		if($row['timeleft'] > 0)
			$verified = _("Valid");
		if($row['timeleft'] < 0)
			$verified = _("Expired");
		if($row['expired'] == 0)
			$verified = _("Pending");
?>
  <tr>
<? if($verified == _("Valid")) { ?>
    <td class="DataTD"><?=$verified?></td>
    <td class="DataTD"><a href="gpg.php?id=3&amp;cert=<?=$row['id']?>"><?=$row['email']?></a></td>
<? } else if($verified == _("Pending")) { ?>
    <td class="DataTD"><?=$verified?></td>
    <td class="DataTD"><?=$row['email']?></td>
<? } else { ?>
    <td class="DataTD"><?=$verified?></td>
    <td class="DataTD"><a href="gpg.php?id=3&amp;cert=<?=$row['id']?>"><?=$row['email']?></a></td>
<? } ?>
    <td class="DataTD"><?=$row['expires']?></td>
    <td class="DataTD"><a href="gpg.php?id=3&amp;cert=<?=$row['id']?>"><?=$row['keyid']?></a></td>

  </tr>
<? } ?>
<? } ?>
</table>
<input type="hidden" name="oldid" value="<?=$id?>">
</form>
