<div>
    <h3>General</h3>
    <p></p>

    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="ski-2fa-enable">Enable</label>
                </th>
                <td>
                    <input id="ski-2fa-enable"
                           type="checkbox"
                           name="ski_wtfa_settings[general][enabled]"
                           value="true"
                           <?php echo isset( $settings['enabled'] ) ? 'checked' : ''; ?> />
                </td>
            </tr>
        </tbody>
    </table>
</div>
