<div class="container" id="register">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <form class="osForm" method="POST" action="<?=get_url('account/register');?>">

	        	<h1 class="mb-10"><?php trans_e("Register", "account"); ?></h1>
	        	<strong><?php trans_e("Your personal information", "account"); ?></strong>
	        	<div class="mb-20 mt-20">
        			<?php //get_view(__FILE__, 'alerts', $message); ?>
	        	</div>

            	<div class="form-group">
	            	<label><?php trans_e("Civility", "account"); ?> <span class="required">*</span></label><br>
	                <label for="id_gender1">
	                    <input type="radio" name="id_gender" id="id_gender1" value="1" checked>
	                    <?php trans_e("Mr.", "account"); ?>
	                </label>
	                <label for="id_gender2">
	                    <input type="radio" name="id_gender" id="id_gender2" value="2" <?=(isset($user->id_gender) && $user->id_gender == '2') ? 'checked' : '';?>>
	                    <?php trans_e("Mrs.", "account"); ?>
	                </label>
            	</div>

            	<div class="form-group">
				    <label for="first_name"><?php trans_e("First name", "account"); ?> <span class="required">*</span></label>
				    <input value="<?=(isset($user->first_name)) ? $user->first_name : '';?>" type="text" name="first_name" class="form-control" id="first_name" placeholder="<?php trans_e("Your First name...", "account"); ?>" required>
				</div>
				<div class="form-group">
				    <label for="last_name"><?php trans_e("Last name", "account"); ?> <span class="required">*</span></label>
				    <input value="<?=(isset($user->last_name)) ? $user->last_name : '';?>" type="text" name="last_name" class="form-control" id="last_name" placeholder="<?php trans_e("Your Last name...", "account"); ?>" required>
				</div>
				<div class="form-group">
				    <label for="email"><?php trans_e("E-mail", "account"); ?> <span class="required">*</span></label>
				    <input value="<?=(isset($user->email)) ? $user->email : '';?>" type="email" name="email" class="form-control" id="email" placeholder="<?php trans_e("Your E-mail...", "account"); ?>" required>
				</div>
				<div class="form-group">
				    <label for="phone"><?php trans_e("Phone number 1", "account"); ?> <span class="required">*</span></label>
				    <input value="<?=(isset($user->phone)) ? $user->phone : '';?>" type="text" name="phone" class="form-control" id="phone" placeholder="<?php trans_e("Your Phone number 1...", "account"); ?>" required>
				</div>
				<div class="form-group">
				    <label for="mobile"><?php trans_e("Phone number 2", "account"); ?></label>
				    <input value="<?=(isset($user->mobile)) ? $user->mobile : '';?>" type="text" name="mobile" class="form-control" id="mobile" placeholder="<?php trans_e("Your Phone number 2...", "account"); ?>">
				</div>
				<div class="form-group">
				    <label for="password"><?php trans_e("Password", "account"); ?> <span class="required">*</span></label>
				    <input value="" type="password" name="password" class="form-control" id="password" placeholder="<?php trans_e("Your Password...", "account"); ?>" required>
				</div>
				<div class="form-group">
				    <label for="city"><?php trans_e("City", "account"); ?> <span class="required">*</span></label>
				    <input value="<?=(isset($user->city)) ? $user->city : '';?>" type="text" name="city" class="form-control" id="city" placeholder="<?php trans_e("Your City...", "account"); ?>" required>
				</div>
				<div class="form-group">
				    <label for="countries"><?php trans_e("Country", "account"); ?> <span class="required">*</span></label>
				    <select name="id_country" id="countries" style="width: 100%;height: 45px;" required>
				    	<option value=""><?php trans_e("Your Country...", "account"); ?></option>
				    	<?php if( !empty($countries) ) : ?>
                           <?php foreach ($countries as $key => $country) : ?>
                                <?php $selected = ($user->id_country == $country->id) ? 'selected' : ''; ?>
                                <option <?= $selected; ?> value="<?= $country->id; ?>"><?= $country->name; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
				    </select>
				</div>
				<div class="form-group">
				    <label for="birth"><?php trans_e("Date of birth", "account"); ?> <span class="required">*</span></label>
					<div class="row">
                        <div class="col-sm-3">
                            <select name="day" style="width:100%;height: 45px;">
                                <?php foreach ($date->days as $day): ?>
                                	<?php $selected = ($user->day == $day) ? 'selected' : ''; ?>
                                    <option value="<?= $day; ?>" <?= $selected; ?>><?= $day; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <select name="month" style="width:100%;height: 45px;">
                                <?php foreach ($date->months as $month): ?>
                                	<?php $selected = ($user->month == $month) ? 'selected' : ''; ?>
                                    <option value="<?= $month; ?>" <?= $selected; ?>><?= $month; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <select name="year" style="width:100%;height: 45px;">
                                <?php foreach ($date->years as $year): ?>
                                	<?php $selected = ($user->year == $year) ? 'selected' : ''; ?>
                                    <option value="<?= $year; ?>" <?= $selected; ?>><?= $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
				</div>
				<div class="form-group">
				    <input name="register" type="submit" class="btn btn-large" value="<?php trans_e("Register", "account"); ?>">
				</div>
            </form>
        </div><!-- /.col-sm-6 -->
    </div><!-- /.row -->
</div><!-- /#reset-password -->