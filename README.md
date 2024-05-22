Bundle, Channel, IPTV Subscription, and User Controls Overview

BundleController:
• Index: Retrieves all bundles from the database.
• Show: Retrieves a specific bundle based on its ID.
• Store: Creates a new bundle with validated data.
• Update: Updates an existing bundle with validated data.
• Disable: Deletes a bundle based on its ID.

ChannelController:
• GetChannelsByCategory: Fetches channels belonging to a specific category for the user's active IPTV subscription.

IPTVSubscriptionController:
• Create: Creates a new IPTV subscription with validated data.
• Show: Retrieves a specific IPTV subscription based on its ID.
• Update: Updates an existing IPTV subscription with validated data.

PasswordController:
• ResetPassword: Resets a user's password by finding the user based on their national ID, updating the password, and deleting existing tokens.

PaymentController:
• CreatePayment: Creates a new payment record, validates user existence, payment amount, and payment method.
• GetPayments: Retrieves a list of payments for a specific user based on their ID.
• DeletePayment: Deletes a subscription record based on its ID.

SubscriptionController:
• Subscribe: Creates a new subscription record for the authenticated user.
• ExtendSubscription: Extends the end date of an existing subscription by 30 days if the current usage is zero and the end date is not within the next 30 days.
• ChangeSpeed: Updates the speed of an existing subscription with validated data.

UserController:
• Show: Shows user details like email and password, which might be a security risk.
• GetUserSubscription: Retrieves the active subscription record for the authenticated user.
